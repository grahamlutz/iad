jQuery(function($){
	console.log('loaded!');

	$('.product .asin-code').click(function() {

		var asinCode = $(this).attr('data-asin-code');
		var category = $(this).attr('data-category');

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
        	console.log(res);
        });

        update.fail(function(res) {
        	console.log(res);
        });
	});

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
        	console.log(res);
        });

        enter.fail(function(res) {
        	console.log(res);
        });
	});

});