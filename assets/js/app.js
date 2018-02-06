(function($) {

	initComponents();

	/**
	 * Frontend component initialization.
	 */
	function initComponents() {
		reset();
	 	sortControl();
	 	toggleMore();
	 	clearInputs();
	 	clearRange();
		log('Coin Development Property WordPress Plugin');
	}

	/**
	 * Reset form fields
	 */ 
	 function reset() {

	 		$('.js-reset').click(function() {
	 			var $form = $(this).closest('form');

	 			$form.find('[type="text"], [type="hidden"]').val("");
	 			$('select option:first-child').prop('selected', true);

	 			$form.find('.js-sort').removeClass('active');
	 		});
	 }

	 /**
	  * Event for the sort custom control.
	  */
	 function sortControl() {
	 	$('.js-sort').click(function() {
	 		var $parent = $(this).parent();
	 		var field = $parent.find('[type="hidden"]');
	 		var $that = $(this);

	 		if($that.is('.sort--asc')) {
	 			$parent.find('.sort--desc').removeClass('active');
	 			$that.addClass('active');
	 			$(field).val('ASC');

	 		} else if($that.is('.sort--desc')) {
	 			$parent.find('.sort--asc').removeClass('active');
	 			$that.addClass('active');
	 			$(field).val('DESC');
	 		}

	 	});
	 }

	/**
	 * Toggle more options for filtration and sorting.
	 */
	function toggleMore() {
		$('.js-more').click(function(e) {
			e.preventDefault();

			$(this).toggleClass('active');

			if($(this).hasClass('active')) {
				$('#more').addClass('active');
			} else {
				$('#more').removeClass('active');
			}
		});
	}

	/** 
	 * Clear filter inputs.
	 */
	function clearInputs() {
		$('.js-button--cancel').click(function(e) {
			e.preventDefault();

			$('#more').find('[type="hidden"], [type="number"]').val('');
			$('#more .active').removeClass('active');
		});
	}

	/**
	 * Clear input range.
	 */
	function clearRange() {
		$('.filter__item.active > .filter__item__title').click(function() {
			$(this).next('.range-group').find('[type="number"]').val('');
			$(this).parent().removeClass('active');

			return;
		});
	}

	/**
	 * Shorthand for console.log
	 *
	 * @param String message The message to log.
	 */
	function log(message) {
		console.log(message);
	}

})(jQuery);
