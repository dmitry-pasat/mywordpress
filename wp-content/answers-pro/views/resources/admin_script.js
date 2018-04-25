(function($) {

	$('.cma_tables a.delete').on('click', function(e) {
		var $this;
		$this = $(this);
		if (confirm('Are you sure? You will lose all your Questions, Answers and Settings!')) {
			return true;
		} else {
			e.preventDefault();
			return false;
		}
	});
	
	$('#cma_categorychecklist, #cma_categorychecklist-pop').each(function() {
		var container = $(this);
		container.find('input:checkbox').change(function() {
			var obj = $(this);
			if (obj.is(':checked')) {
//				console.log($(this).attr('value'));
				var other = container.find('input:checkbox:checked[value!="'+ $(this).attr('value') +'"]');
//				console.log(other);
				other.click();
			}
		});
	});
	
	
	$('.cma-user-related-questions .cma-remove-button').click(function(ev) {
		ev.preventDefault();
		ev.stopPropagation();
		$(this).parents('tr').first().remove();
	});
	
	
	var debugEmail = function(wrapper) {
		var btn = wrapper.find('input[type=button]');
		var input = wrapper.find('input[type=email]');
		btn.hide();
		var loader = $('<div>', {"class":"cma-loader-bar"});
		input.after(loader);
		var data = {action: 'cma_debug_email', email: input.val(), nonce: wrapper.data('nonce')};
		$.post(ajaxurl, data, function(response) {
			loader.remove();
			btn.show();
			var className = 'cma-debug-email-response';
			var result = wrapper.find('.' + className);
			if (result.length == 0) {
				result = $('<div>', {"class":className});
				wrapper.append(result);
			}
			result.text(response);
		});
	};
	$('.cma-debug-email input[type=email]').keypress(function(ev) {
		if (ev.keyCode == 13) {
			ev.stopPropagation();
			ev.preventDefault();
			debugEmail($(this).parents('.cma-debug-email'));
		}
	});
	$('.cma-debug-email input[type=button]').click(function(ev) {
		ev.stopPropagation();
		ev.preventDefault();
		debugEmail($(this).parents('.cma-debug-email'));
	});
	

})(jQuery);
