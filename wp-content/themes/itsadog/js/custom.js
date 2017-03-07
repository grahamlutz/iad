jQuery(function($){
	
  // Update registry product when user clicks on image of product in 
  // category popup during homepage sign up process

	$('.tab-pane').on('click', '.product .asin-code', addDeleteRegistryItem);

  function addDeleteRegistryItem (e) {
    e.preventDefault;

    var asinCode    = $(this).attr('data-asin-code');
    var category    = $(this).attr('data-category').replace(/-/g, '_');
    var postId      = $(this).attr('data-post-id');
    var productHTML = $(this).parent();

    var data = {
                   "action":"updateRgistryProduct",
                   "asin": asinCode,
                   "category": category,
                }

    callToPHP(data);

    moveRegistryItem(productHTML, category);

    return false;
  }

  function moveRegistryItem(productHTML, category) {

    if (productHTML.parent().hasClass('in-registry')) {
      productHTML.detach();
      productHTML.appendTo('.' + category + ' .not-in-registry');
      return false;
    } 
    if (productHTML.parent().hasClass('not-in-registry')) {
      productHTML.remove();
      productHTML.appendTo('.' + category + ' .in-registry');
      return false;
    }

  }

  // Enter Sweepstakes.  This updates user_meta 'entered_sweepstakes' to 'true'.

	$('.enter-sweepstakes').click(function() {

		var data = { "action":"enterSweepstakes" }
    callToPHP(data);

	});

  $('.logged-in-subscribe').click(function() {

    var data = { "action":"mailChimpSubscribe" }
    callToPHP(data);

    // TODO: Display some message that they have successfully subscribed
  });

  //
  // Social Sharing
  //

  $('.manage-dog-box').on('click', '.facebook button', facebookShare);

  function facebookShare(e) {
    var url = window.location.hostname;
    var name = $(e.target).attr('data-dog-name');
    name = name.replace(' ', '-');
    console.log('name: ', name);
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

    // Create and append Twitter buttons
    var twitterAnchor = $('<a>');
    twitterAnchor.addClass('twitter-share-button')
                 .attr('href', tweetUrl)
                 .attr('data-size', 'large')
                 .attr('data-text', quote)
                 .attr('data-url', url)
                 .text('Tweet');
    $('.' + dogID + ' .twitter').append(twitterAnchor);

    // Create and append Email buttons
    var emailAnchor = $('<a>');
    var emailText = "mailto:?to=&body=";
        emailText += encodeURIComponent(quote); 
        emailText += " " ;
        emailText += url;
        emailText += ",&subject=";
        emailText += encodeURIComponent(quote);
    emailAnchor.attr('href', emailText);
    emailAnchor.text('Email');
    $('.' + dogID + ' .email').append(emailAnchor);
  };

  function callToPHP( data, callback ) {
    $.ajax({
           method:   'POST',
           url:      ajaxurl,
           data:     data,
           dataType: 'text'
        })

        .done(function(res) {
          if(callback) {
            callback(res);
          }
          console.log('success');
          console.log(res);
        })

        .fail(function(res) {
          console.log('failure');
          console.log(res);
        });
  }

});