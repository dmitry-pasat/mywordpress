jQuery(function($) {
	
	var ajaxRequest = function(request, callback) {
		$.ajax(request.url, {
			type: request.type,
			data: request.data,
			success: callback,
		});
	};
	
	
	var object2url = function(obj) {
		var url = '';
		for (var name in obj) {
			if (obj.hasOwnProperty(name)) {
				if (url.length > 0) url += '&';
				url += encodeURIComponent(name) + '=' + encodeURIComponent(obj[name]);
			}
		}
		return url;
	};
	
	
	var combineUrlWithData = function(request) {
		var url = request.url;
		if (typeof(request.type) == 'undefined' || request.type.toLowerCase() == 'get') {
			if (typeof(request.data) != 'undefined') {
				url += (url.indexOf('?') >= 0 ? '&' : '?');
				url += object2url(request.data);
			}
		}
		return url;
	};
	
	
	var pushState = function(request, wrapper) {
		var url = combineUrlWithData(request);
		var stateObj = {wrapperId: wrapper.attr('id'), currentUrl: location.href, newUrl: url, request: request};
		console.log('CMA.pushstate', url, stateObj);
		history.pushState(stateObj, url, url);
	};
	
	
	var loadContent = function(request, wrapper, preventPushState) {
		if (!preventPushState) pushState(request, wrapper);
		createLoader(wrapper);
		ajaxRequest(request, function(response) {
			response = $(response);
			var responseWrapper = response.find('.cma-questions-widget.cma-main-query, .cma-thread-wrapper');
			wrapper.html(responseWrapper.html());
			wrapper.trigger('CMA.initHandlers');
		});
	};
	
	var stopEvent = function(ev) {
		ev.stopPropagation();
		ev.preventDefault();
	};
	
	var createLoader = function(wrapper) {
		var loader = $('<div>', {'class': 'cma-loader'});
		wrapper.append(loader);
		wrapper.addClass('cma-loading');
	};
	
	
	var createRequestDataObject = function(form) {
		var data = {};
		var inputs = form.find('input[name], select[name], textarea[name]');
		for (var i=0; i<inputs.length; i++) {
			var input = $(inputs[i]);
			var name = input.attr('name');
			var value = input.val();
			data[name] = value;
		}
		return data;
	};
	
	
	'CMA.initHandlers'.newEventListener(function(ev) {
		
		var wrapper = $(ev.target);
		if (!wrapper.hasClass('cma-questions-widget')) {
			wrapper = $('.cma-questions-widget', wrapper);
		}
		
		var handleLink = function(ev) {
			stopEvent(ev);
			var btn = $(this);
			createLoader(wrapper);
			loadContent({url: btn.attr('href')}, wrapper);
		};
		
		var handleFormSubmit = function(ev) {
			stopEvent(ev);
			var form = $(this);
			createLoader(wrapper);
			var data = createRequestDataObject(form);
			loadContent({url: form.attr('action'), type: form.attr('method'), data: data}, wrapper);
		};
		
		$('.cma-pagination a', wrapper).click(handleLink);
		$('.cma-thread-orderby a', wrapper).click(handleLink);
		$('.cma-thread-title a', wrapper).click(handleLink);
		$('.cma-breadcrumbs a', wrapper).click(handleLink);
		$('.cma-filter', wrapper).submit(handleFormSubmit);
		
	});
	
	$(window).on('popstate', function(event) {
		console.log('CMA.popstate', location.href, event.originalEvent.state, event);
		var state = event.originalEvent.state;
		if (!state) {
			loadContent({url: location.href}, $('.cma-questions-widget.cma-main-query'), preventPushState = true);
		} else {
			loadContent({url: location.href}, $('#' + state.wrapperId), preventPushState = true);
		}
	});
	
	$('body').trigger('CMA.initHandlers');
	
});




String.prototype.newEventListener = function(func) {
	jQuery(document).on(this.toString(), func);
};


// Convert from normal to web-safe, strip trailing "="s
String.prototype.base64EncodeWebSafe = function() {
    return this.toString().base64Encode().replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
};

// Convert from web-safe to normal, add trailing "="s
String.prototype.base64DecodeWebSafe = function() {
	var str = this.toString();
    var result = str.replace(/\-/g, '+').replace(/_/g, '/') + '=='.substring(0, (3*str.length)%4);
    return result.base64Decode();
};

String.prototype.base64Encode = function() {
	var str = this.toString();
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
};

String.prototype.base64Decode = function() {
	var str = this.toString();
    // Going backwards: from bytestream, to percent-encoding, to original string.
    return decodeURIComponent(atob(str).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
};
