!function(t){"use strict";t(document).ready(function(){t(".fl-post-feed-post").each(function(){var p=t(this).find(".post-featured-image"),o=p.html();p.css({"background-image":"url("+o+")",opacity:"1"})}),t(window).on("load resize",function(){t(window).width()>600?(p("body:not(.paged) .blog-archive-2 .pp-posts-wrapper .pp-content-post-grid .pp-content-post",!0),p("body.paged .blog-archive-2 .pp-posts-wrapper .pp-content-post-grid .pp-content-post")):t(".blog-archive-2 .pp-posts-wrapper .pp-content-post-grid .pp-content-post").each(function(){t(this).height("auto")})}),"objectFit"in document.documentElement.style==!1&&t(".blog-archive-2 .pp-posts-wrapper .pp-content-post-grid .pp-content-post").each(function(){t(this).find(".pp-post-featured-img .fl-photo .fl-photo-content a").addClass("no-object-fit")});var p=function(p,o){o=o||!1,t(p).each(function(p){t(this).height("unset")});var e=t(p).map(function(){return t(this).height()}).get();!0===o&&e.shift();var n=Math.max.apply(null,e);t(p).each(function(p){o?p>0&&(t(this).height(n+80),t(this).css("max-height",n+80+"px")):(t(this).height(n+80),t(this).css("max-height",n+80+"px"))})}})}(jQuery);
function getURLParameterByName(e){e=e.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");var t=new RegExp("[\\?&]"+e+"=([^&#]*)").exec(location.search);return null===t?"":decodeURIComponent(t[1].replace(/\+/g," "))}!function(e){var t=!1;if("function"==typeof define&&define.amd&&(define(e),t=!0),"object"==typeof exports&&(module.exports=e(),t=!0),!t){var n=window.Cookies,o=window.Cookies=e();o.noConflict=function(){return window.Cookies=n,o}}}(function(){function e(){for(var e=0,t={};e<arguments.length;e++){var n=arguments[e];for(var o in n)t[o]=n[o]}return t}return function t(n){function o(t,i,r){var a;if("undefined"!=typeof document){if(arguments.length>1){if("number"==typeof(r=e({path:"/"},o.defaults,r)).expires){var u=new Date;u.setMilliseconds(u.getMilliseconds()+864e5*r.expires),r.expires=u}try{a=JSON.stringify(i),/^[\{\[]/.test(a)&&(i=a)}catch(e){}return i=n.write?n.write(i,t):encodeURIComponent(String(i)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),t=(t=(t=encodeURIComponent(String(t))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape),document.cookie=[t,"=",i,r.expires?"; expires="+r.expires.toUTCString():"",r.path?"; path="+r.path:"",r.domain?"; domain="+r.domain:"",r.secure?"; secure":""].join("")}t||(a={});for(var m=document.cookie?document.cookie.split("; "):[],c=/(%[0-9A-Z]{2})+/g,s=0;s<m.length;s++){var p=m[s].split("="),l=p.slice(1).join("=");'"'===l.charAt(0)&&(l=l.slice(1,-1));try{var d=p[0].replace(c,decodeURIComponent);if(l=n.read?n.read(l,d):n(l,d)||l.replace(c,decodeURIComponent),this.json)try{l=JSON.parse(l)}catch(e){}if(t===d){a=l;break}t||(a[d]=l)}catch(e){}}return a}}return o.set=o,o.get=function(e){return o.call(o,e)},o.getJSON=function(){return o.apply({json:!0},[].slice.call(arguments))},o.defaults={},o.remove=function(t,n){o(t,"",e(n,{expires:-1}))},o.withConverter=t,o}(function(){})});var source=getURLParameterByName("utm_source"),medium=getURLParameterByName("utm_medium"),campaign=getURLParameterByName("utm_campaign"),term=getURLParameterByName("utm_term"),content=getURLParameterByName("utm_content"),contact_email=getURLParameterByName("email");function setValue(e,t){t||(t=""),e.val(t)}function addEmailCookie(e){Cookies.set("hip_email",e)}source.length?Cookies.set("utm_source",source):source=Cookies.get("utm_source"),medium.length?Cookies.set("utm_medium",medium):medium=Cookies.get("utm_medium"),campaign.length?Cookies.set("utm_campaign",campaign):campaign=Cookies.get("utm_campaign"),term.length?Cookies.set("utm_term",term):term=Cookies.get("utm_term"),content.length?Cookies.set("utm_content",content):content=Cookies.get("utm_content"),window.onload=function(){setValue(jQuery(".utm_source input"),source),setValue(jQuery(".utm_medium input"),medium),setValue(jQuery(".utm_campaign input"),campaign),setValue(jQuery(".utm_content input"),content),setValue(jQuery(".utm_term input"),term),setValue(jQuery(".url input"),window.location.href),setValue(jQuery(".hidden_email input"),contact_email)};
!function(e){var t,n=e("header .c-hamburger"),i=e("header .mobile-menu-wrap");!function(t){t.click(function(t){t.preventDefault(),e(this).toggleClass("is-active"),i.slideToggle(),i.toggleClass("is-open"),e("body").toggleClass("prevent-scroll")}),i.find(".menu-item-has-children > a").removeAttr("href"),i.find(".menu-item-has-children").click(function(t){t.preventDefault(),t.stopPropagation(),e(this).children(".sub-menu").slideToggle(),e(this).toggleClass("rotated")}),i.find(".sub-menu li:not(.menu-item-has-children) a").click(function(e){e.stopPropagation()})}(n),"iOS"==(t=navigator.userAgent||navigator.vendor||window.opera,/windows phone/i.test(t)?"Windows Phone":/android/i.test(t)?"Android":/iPad|iPhone|iPod/.test(t)&&!window.MSStream?"iOS":"unknown")&&(e("html").css("height","100%"),e("html").css("overflow-y","scroll"),e("html").css("-webkit-overflow-scrolling","touch"),e("body").css("height","100%"),e("body").css("overflow-y","scroll"),e("body").css("-webkit-overflow-scrolling","touch"),e(window).on("load",function(){var t=e(".flatpickr-input");t.length>0&&t.each(function(){e(this).on("focus",function(){e("html").css("overflow-y","unset"),e("body").css("overflow-y","unset")}),e(this).on("change",function(){e("html").css("overflow-y","scroll"),e("body").css("overflow-y","scroll")})})})),e(".tab .menu li.page_item_has_children, .tab .menu li.menu-item-has-children").children("a").removeAttr("href"),e(".tab .menu li.page_item_has_children, .tab .menu li.menu-item-has-children").on("click",function(t){t.stopPropagation(),t.preventDefault(),e(this).toggleClass("selected"),e(this).children("ul").slideToggle()}),e(".tab .sub-menu li:not(.menu-item-has-children) a").click(function(e){e.stopPropagation()}),e(".tab button").click(function(){var t;e(this).data("url")?(e(this).parent().addClass("selected"),location=e(this).data("url")):((t=e(this).parent().children("div")).parent().hasClass("selected")?t.parent().removeClass("selected"):t.parent().addClass("selected"),t.parent().siblings(".tab").removeClass("selected"))})}(jQuery);
!function(){"use strict";if("objectFit"in document.documentElement.style==!1){var t=function(t,e,i){var n,o,l,a,s;if((i=i.split(" ")).length<2&&(i[1]=i[0]),"x"===t)n=i[0],o=i[1],l="left",a="right",s=e.clientWidth;else{if("y"!==t)return;n=i[1],o=i[0],l="top",a="bottom",s=e.clientHeight}if(n!==l&&o!==l){if(n!==a&&o!==a)return"center"===n||"50%"===n?(e.style[l]="50%",void(e.style["margin-"+l]=s/-2+"px")):void(n.indexOf("%")>=0?(n=parseInt(n))<50?(e.style[l]=n+"%",e.style["margin-"+l]=s*(n/-100)+"px"):(n=100-n,e.style[a]=n+"%",e.style["margin-"+a]=s*(n/-100)+"px"):e.style[l]=n);e.style[a]="0"}else e.style[l]="0"},e=function(e){var i=e.dataset?e.dataset.objectFit:e.getAttribute("data-object-fit"),n=e.dataset?e.dataset.objectPosition:e.getAttribute("data-object-position");i=i||"cover",n=n||"50% 50%";var o=e.parentNode;!function(t){var e=window.getComputedStyle(t,null),i=e.getPropertyValue("position"),n=e.getPropertyValue("overflow"),o=e.getPropertyValue("display");i&&"static"!==i||(t.style.position="relative"),"hidden"!==n&&(t.style.overflow="hidden"),o&&"inline"!==o||(t.style.display="block"),0===t.clientHeight&&(t.style.height="100%"),-1===t.className.indexOf("object-fit-polyfill")&&(t.className=t.className+" object-fit-polyfill")}(o),function(t){var e=window.getComputedStyle(t,null),i={"max-width":"none","max-height":"none","min-width":"0px","min-height":"0px",top:"auto",right:"auto",bottom:"auto",left:"auto","margin-top":"0px","margin-right":"0px","margin-bottom":"0px","margin-left":"0px"};for(var n in i)e.getPropertyValue(n)!==i[n]&&(t.style[n]=i[n])}(e),e.style.position="absolute",e.style.height="100%",e.style.width="auto","scale-down"===i&&(e.style.height="auto",e.clientWidth<o.clientWidth&&e.clientHeight<o.clientHeight?(t("x",e,n),t("y",e,n)):(i="contain",e.style.height="100%")),"none"===i?(e.style.width="auto",e.style.height="auto",t("x",e,n),t("y",e,n)):"cover"===i&&e.clientWidth>o.clientWidth||"contain"===i&&e.clientWidth<o.clientWidth?(e.style.top="0",e.style.marginTop="0",t("x",e,n)):"scale-down"!==i&&(e.style.width="100%",e.style.height="auto",e.style.left="0",e.style.marginLeft="0",t("y",e,n))},i=function(t){if(void 0===t)t=document.querySelectorAll("[data-object-fit]");else if(t&&t.nodeName)t=[t];else{if("object"!=typeof t||!t.length||!t[0].nodeName)return!1;t=t}for(var i=0;i<t.length;i++)if(t[i].nodeName){var n=t[i].nodeName.toLowerCase();"img"===n?t[i].complete?e(t[i]):t[i].addEventListener("load",function(){e(this)}):"video"===n&&(t[i].readyState>0?e(t[i]):t[i].addEventListener("loadedmetadata",function(){e(this)}))}return!0};document.addEventListener("DOMContentLoaded",function(){i()}),window.addEventListener("resize",function(){i()}),window.objectFitPolyfill=i}else window.objectFitPolyfill=function(){return!1}}();
//# sourceMappingURL=parent.js.map