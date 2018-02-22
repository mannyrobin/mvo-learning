/**
 * campaign.js
 *
 * Passing UTM parameters to forms and stores them as cookies
 */

/*!
 * JavaScript Cookie v2.1.3
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;(function (factory) {
	var registeredInModuleLoader = false;
	if (typeof define === 'function' && define.amd) {
		define(factory);
		registeredInModuleLoader = true;
	}
	if (typeof exports === 'object') {
		module.exports = factory();
		registeredInModuleLoader = true;
	}
	if (!registeredInModuleLoader) {
		var OldCookies = window.Cookies;
		var api = window.Cookies = factory();
		api.noConflict = function () {
			window.Cookies = OldCookies;
			return api;
		};
	}
}(function () {
	function extend () {
		var i = 0;
		var result = {};
		for (; i < arguments.length; i++) {
			var attributes = arguments[ i ];
			for (var key in attributes) {
				result[key] = attributes[key];
			}
		}
		return result;
	}
	
	function init (converter) {
		function api (key, value, attributes) {
			var result;
			if (typeof document === 'undefined') {
				return;
			}
			
			// Write
			
			if (arguments.length > 1) {
				attributes = extend({
					path: '/'
				}, api.defaults, attributes);
				
				if (typeof attributes.expires === 'number') {
					var expires = new Date();
					expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
					attributes.expires = expires;
				}
				
				try {
					result = JSON.stringify(value);
					if (/^[\{\[]/.test(result)) {
						value = result;
					}
					} catch (e) {}
					
					if (!converter.write) {
						value = encodeURIComponent(String(value))
						.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
					} else {
						value = converter.write(value, key);
					}
					
					key = encodeURIComponent(String(key));
					key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
					key = key.replace(/[\(\)]/g, escape);
					
					return (document.cookie = [
					key, '=', value,
					attributes.expires ? '; expires=' + attributes.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
									attributes.path ? '; path=' + attributes.path : '',
						 attributes.domain ? '; domain=' + attributes.domain : '',
						 attributes.secure ? '; secure' : ''
					].join(''));
				}
				
				// Read
				
				if (!key) {
					result = {};
				}
				
				// To prevent the for loop in the first place assign an empty array
				// in case there are no cookies at all. Also prevents odd result when
				// calling "get()"
				var cookies = document.cookie ? document.cookie.split('; ') : [];
				var rdecode = /(%[0-9A-Z]{2})+/g;
				var i = 0;
				
				for (; i < cookies.length; i++) {
					var parts = cookies[i].split('=');
					var cookie = parts.slice(1).join('=');
					
					if (cookie.charAt(0) === '"') {
						cookie = cookie.slice(1, -1);
					}
					
					try {
						var name = parts[0].replace(rdecode, decodeURIComponent);
						cookie = converter.read ?
						converter.read(cookie, name) : converter(cookie, name) ||
						cookie.replace(rdecode, decodeURIComponent);
						
						if (this.json) {
							try {
								cookie = JSON.parse(cookie);
							} catch (e) {}
						}
						
						if (key === name) {
							result = cookie;
							break;
						}
						
						if (!key) {
							result[name] = cookie;
						}
					} catch (e) {}
				}
				
				return result;
			}
			
			api.set = api;
			api.get = function (key) {
				return api.call(api, key);
			};
			api.getJSON = function () {
				return api.apply({
					json: true
				}, [].slice.call(arguments));
			};
			api.defaults = {};
			
			api.remove = function (key, attributes) {
				api(key, '', extend(attributes, {
					expires: -1
				}));
			};
			
			api.withConverter = init;
			
			return api;
		}
		
		return init(function () {});
	}));

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
// Give the URL parameters variable names
var source = getParameterByName('utm_source');
var medium = getParameterByName('utm_medium');
var campaign = getParameterByName('utm_campaign');
var term = getParameterByName( 'utm_term' );
var content = getParameterByName( 'utm_content' );
var contact_email = getParameterByName( 'email' );

// Set the cookies
if( source.length ) {
	Cookies.set('utm_source', source);
} else {
	source = Cookies.get('utm_source');
}

if( medium.length ) {
	Cookies.set('utm_medium', medium);
} else {
	medium = Cookies.get( 'utm_medium' );
}

if( campaign.length ) {
	Cookies.set('utm_campaign', campaign);
} else {
	campaign = Cookies.get( 'utm_campaign' );
}

if( term.length ) {
	Cookies.set('utm_term', term);
} else {
	term = Cookies.get( 'utm_term' );
}

if( content.length ) {
	Cookies.set('utm_content', content);
} else {
	content = Cookies.get( 'utm_content' );
}

function setValue( el, value ) {
	if ( ! value ) {
		value = '';
	}
	
	el.val(value);
}

function addEmailCookie( email ) {
	Cookies.set( 'hip_email', email );
}

window.onload = function() {
	setValue(jQuery('.utm_source input'), source );
	setValue(jQuery('.utm_medium input'), medium );
	setValue(jQuery('.utm_campaign input'), campaign );
	setValue(jQuery('.utm_content input'), content );
	setValue(jQuery('.utm_term input'), term );
	setValue(jQuery('.url input'), window.location.href );
	setValue(jQuery('.hidden_email input' ), contact_email );
};
