// DOM Ready
jQuery(function($) {
	'use strict';
    var $el, leftPos, newWidth, $el_parent;
    
    /* Add Magic Line markup via JavaScript, because it ain't gonna work without */
    $(".menu-bar .main-nav > ul").append("<li id='magic-line'></li>");
    
    /* Cache it */
    var $magicLine = $("#magic-line");
	if($(".menu-bar .main-nav > ul").children("li.current").length===0){
	    $(".menu-bar .main-nav > ul > li:first-child").addClass('current');
	}

	
	if ( jQuery( "#magic-line" ).length ) {
		$magicLine
			.width($(".menu-bar .main-nav .current").width())
			.css("left", $(".menu-bar .main-nav > ul > li.current > a").position().left)
			.data("origLeft", $magicLine.position().left)
			.data("origWidth", $magicLine.width());
	}
        
    $(".menu-bar .main-nav > ul > li").not($magicLine).mouseenter( function() {

			$el = $(this).children('a');
			$el_parent = $el.parent().parent().closest('li');
			if(  $el_parent[0] === undefined ){
				leftPos = $el.position().left;
				//console.log('leftPos : ' + leftPos);
				newWidth = $el.parent().width();
				//console.log('newWidth : ' + newWidth);
				//console.log($el_parent[0]);
			}else{
				$el_parent = $el.closest('.menu-parent-item');
				leftPos = $el_parent.children('a').position().left;
				
				newWidth = $el_parent.width();
			}
			
			$magicLine.stop().animate({
				left: leftPos,
				width: newWidth
			});
		
    }).mouseleave( function() {
        $magicLine.stop().animate({
            left: $(".menu-bar .main-nav .current > a").position().left,
            width: $(".menu-bar .main-nav .current").width() 
        });
    });
	$(window).on("scroll", function() {
		
		//if (window.scrollY == 0) {
		//	alert();
		//...
			$magicLine.stop().animate({
				left: $(".menu-bar .main-nav .current > a").position().left,
				width: $(".menu-bar .main-nav .current").width() 
			});
		//}
  });
    
});