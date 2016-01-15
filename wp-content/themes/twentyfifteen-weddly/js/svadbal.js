(function($,undefined){
	$(function() {
	    $("img.lazyload").lazyload({
	    	effect : "fadeIn",
	    	failure_limit : 10
	    });
	});
	seo($(".js-text"),$(".js-textplaceholder"));
	$(document).on('click', '.js-boxLink', function(){
		window.location = $(this).find('a').attr('href');
	});
	$(window).load(function(){
		seo($(".js-text"),$(".js-textplaceholder"));		
		setTimeout(function(){seo($(".js-text"),$(".js-textplaceholder"));},5000);
	});
})(jQuery);

function seo(text, placeholder){
	if(typeof text !== typeof undefined && text !== false && typeof placeholder !== typeof undefined && placeholder !== false && placeholder.length > 0 && text.length > 0){
		var seoHeight = text.outerHeight(),
		seoTop = placeholder.offset().top;
	 	placeholder.css({
			height: seoHeight+"px"
		});
		text.css({
			position: 'absolute',
			top: seoTop+'px'
		});
		//console.log(seoHeight);
	}
}
