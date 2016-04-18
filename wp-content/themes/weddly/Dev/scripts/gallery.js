$(function(){

        function parseThumbnailElements(gallerySelector) {
            var $thumbElements = $(gallerySelector).find('.gallery__item'),
                items = [],
                $linkEl,
                item;

            $thumbElements.each(function (i) {
                $(this).data('index',i);
                $linkEl = $(this).find('a');
                item = {
                    src: $linkEl.attr('href'),
                    msrc: $linkEl.attr('href'),
                    w: $linkEl.data('width'),
                    h: $linkEl.data('height'),
                    title: $(this).find('figcpure').html() || '',
                    el: $(this)
                };
                items.push(item);
            });

            return items;
        };


    var  items = parseThumbnailElements('.js-gallery');
    $(document).on('click', '.gallery__item__link', function (e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
        var index = $(this).parent('.gallery__item').data('index');
        if(index >= 0) {
            openPhotoSwipe( index, items);
        }

    });
    function openPhotoSwipe(index, items) {
        var pswpElement = $('.pswp')[0],
            gallery,
            options;

        // items = parseThumbnailElements(galleryElement);

        // define options (if needed)
        options = {
            index: index,
            history: false,
            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.find('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect();
                console.log({x:rect.left, y:rect.top + pageYScroll, w:rect.width});
                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            }

        };





        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };


});