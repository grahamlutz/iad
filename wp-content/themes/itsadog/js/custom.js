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

  $('.facebook button').click(function() {
    var url = window.location.hostname;
    var name = $(this).attr('data-dog-name');
    console.log('url: ', url);
    console.log('name: ', name);
    var data = {
      method: 'share',
      href: url + "/dog/" + name,
    }

    FB.ui(data , function(response){
      console.log('tada: ', response);
    });
  })

});