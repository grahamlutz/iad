jQuery(function($){
	
  // Update registry product when user clicks on image of product in 
  // category popup during homepage sign up process

	$('.product .asin-code').click(function(e) {

    e.preventDefault;

		var asinCode = $(this).attr('data-asin-code');
		var category = $(this).attr('data-category').replace(/-/g, '_');

		var data = {
                   "action":"updateRgistryProduct",
                   "asin": asinCode,
                   "category": category,
                }

		var update = $.ajax({
           method:   'POST',
           url:      ajaxurl,
           data:     data,
           dataType: 'text'
        });

        update.done(function(res) {
        	// console.log('success: ', res);
        });

        update.fail(function(res) {
        	// console.log(res);
        });

    $('.' + category + 'Modal').modal('hide');

    return false;
	});

  // Enter Sweepstakes.  This updates user_meta 'entered_sweepstakes' to 'true'.

	$('.enter-sweepstakes').click(function() {

		var data = {
                   "action":"enterSweepstakes"
                }

		var enter = $.ajax({
           method:   'POST',
           url:      ajaxurl,
           data:     data,
           dataType: 'text'
        });

        enter.done(function(res) {
        	// console.log('success: ', res);
        });

        enter.fail(function(res) {
        	// console.log(res);
        });
	});

  $('.logged-in-subscribe').click(function() {

    console.log('logged-in-subscribe');

    var data = {
                   "action":"mailChimpSubscribe"
                }

    var enter = $.ajax({
           method:   'POST',
           url:      ajaxurl,
           data:     data,
           dataType: 'text'
        });

        enter.done(function(res) {
          console.log('success: ', res);
        });

        enter.fail(function(res) {
          // console.log(res);
        });

    // TODO: Display some message that they have successfully subscribed
  });


  //
  // Social Sharing
  //


  $('.manage-dog-box').click(function(e) {

    if ( $(e.target).parent().hasClass('facebook') ){
      facebookShare(e);
      return;
    }

  });

  function facebookShare(e) {
    var url = window.location.hostname;
    var name = $(e.target).attr('data-dog-name');
    name = name.replace(' ', '-');
    var quote = "Check out my registry! #itsadog";

    var data = {
      method: 'share',
      quote: quote,
      href: url + "/dog/" + name,
    }

    FB.ui(data , function(response){
      // console.log('tada: ', response);
    });
  }

  var dogBox = $('.manage-dog-box');

  $.each(dogBox, setShareButtons)

  function setShareButtons() {

    var quote = "Check out my registry! #itsadog";
    var dogName = $(this).attr('data-dog-name');
    var dogID = $(this).attr('data-dog-id');
    var host = window.location.host;
    var url = "http://"; 
        url += host;
        url += "/dog/";
        url += dogName.replace(/\s/g, "-");
    var tweetUrl = "http://www.twitter.com/share";
        // tweetUrl += "?url=";
        // tweetUrl += url;
        // tweetUrl += "&text=";
        // tweetUrl += encodeURIComponent(quote);

    // Create and append Twitter buttons
    var twitterAnchor = $('<a>');
    twitterAnchor.addClass('twitter-share-button');
    twitterAnchor.attr('href', tweetUrl);
    twitterAnchor.attr('data-size', 'large');
    twitterAnchor.attr('data-text', quote);
    twitterAnchor.attr('data-url', url);
    twitterAnchor.text('Tweet');
    $('.' + dogID + ' .twitter').append(twitterAnchor);
    // twttr.widgets.load();

    // Create and append Email buttons
    var emailAnchor = $('<a>');
    var emailText = encodeURIComponent(quote) + " " + url;
    emailAnchor.attr('href', emailText);
    emailAnchor.text('Email');
    $('.' + dogID + ' .email').append(emailAnchor);
  };

});