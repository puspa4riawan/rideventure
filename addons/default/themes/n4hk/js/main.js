// Placeholder lazyload
window.addEventListener('load', function(event) {
    $('.ph-item').waitForImages(function() {
        $(this).remove();
    });
    
    // Lazzyload Images
    var images = document.querySelectorAll('[data-original], [data-src-original]');
    var lazy = lazyload(images, {'src': 'data-original', 'srcset': 'data-src-original'});

    $(function(){
        jQuery('img.svg').each(function(){
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('data-original');
        
            jQuery.get(imgURL, function(data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');
        
                // Add replaced image's ID to the new SVG
                if(typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if(typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass+' replaced-svg');
                }
        
                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');
                
                // Check if the viewport is set, else we gonna set it if we can.
                if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                    $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
                }
        
                // Replace image with new SVG
                $img.replaceWith($svg);
        
            }, 'xml');
        
        });
    });
    
});

$(document).ready(function() {

    // Toggle Main Navigation Menu Mobile
    if( $('.fn-toggle-nav-menu').length ) {
        $('.fn-toggle-nav-menu').click(function() {
            $('.main-nav').toggleClass('is-active');
        });
    }
});