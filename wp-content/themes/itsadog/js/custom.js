jQuery(function($){
	
  // Update registry product when user clicks on image of product in 
  // category popup during homepage sign up process

	$('.product .asin-code').click(function(e) {

    // console.log('update registry product');

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

  $('.manage-dog-box').click(function(e) {
    console.log('manage-dog-box');

    if ( $(e.target).parent().hasClass('facebook') ){
      facebookShare(e);
      return;
    }

    if ( $(e.target).parent().hasClass('twitter') ){
      console.log('twitter');
      twitterShare(e);
      return;
    }

    if ( $(e.target).parent().hasClass('instagram') ){
      instagramShare(e);
      return;
    }

    if ( $(e.target).parent().hasClass('email') ){
      emailShare(e);
      return;
    }

  })

  function facebookShare(e) {
    var url = window.location.hostname;
    var name = $(e.target).attr('data-dog-name');
    name = name.replace(' ', '-');
    var quote = $(this).children('.dog-info').children('.row').children('textarea').val();

    var data = {
      method: 'share',
      quote: quote,
      href: url + "/dog/" + name,
    }

    FB.ui(data , function(response){
      // console.log('tada: ', response);
    });
  }

  function twitterShare(e) {
    console.log('tada!');
  }

  function instagramShare(e) {

  }

  function emailShare(e) {

  }

  var dogBox = $('.manage-dog-box');

  $.each(dogBox, setTwitterButtons)

  function setTwitterButtons() {

    var dogName = $(this).attr('data-dog-name');
    var dogID = $(this).attr('data-dog-id');
    var hostname = window.location.hostname;
    var quote = $(this).children('.dog-info').children('.row').children('textarea').val();
    var url = hostname + "/dog/" + encodeURIComponent(dogName) + "?text=" + encodeURIComponent(quote);
    console.log(url);

    var twitterAnchor = $('<a>');
    twitterAnchor.addClass('twitter-share-button');
    twitterAnchor.attr('href', url);
    $('.' + dogID + ' .twitter').append(twitterAnchor);

  };

});