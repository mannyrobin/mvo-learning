(function ($) {
    "use strict";
    $(document).ready(function () {
        /*load more button for videos*/
        var nextPostsLink = $('.video-gallery-wrapper .fl-builder-pagination ul li a.next'),
            loadMoreBtn = $('.video-gallery-wrapper .load-more-btn a'),
            posts = '',
            postsGrid = $('.video-gallery-wrapper .video-container');
        if (nextPostsLink.length !== 0) {
            loadMoreBtn.attr('href', nextPostsLink.attr('href'));
        } else {
            loadMoreBtn.attr('href', '#').hide();
        }
        loadMoreBtn.on('click', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if(url.indexOf('?')> 0){
                url = url.replace(url.slice(url.indexOf('?')),'');
            }
            var urlSegments = url.split('/'),
                curPage = url.match(/([^\/]*)\/*$/)[1];
            urlSegments[urlSegments.indexOf(curPage)] = parseInt(curPage) + 1;
            if (url !== '#') {
                $.ajax({
                    url: url,
                    beforeSend: function () {
                        loadMoreBtn.addClass('loading').html('Loading...');
                        $('.video-gallery-wrapper .video-container').css('opacity','0.5');
                    },
                    success: function (result) {
                        posts = $(result).find('.video-gallery-wrapper .video-container').children();
                        postsGrid.append(posts);
                        if (posts.length > 0) {
                            loadMoreBtn.attr('href',  urlSegments.join('/'));
                        } else {
                            loadMoreBtn.hide();
                            loadMoreBtn.before('<p>No more videos to show !</p>');
                        }
                    },
                    complete: function () {
                        loadMoreBtn.removeClass('loading').html('Load More Video');
                        $('.video-gallery-wrapper .video-container').css('opacity','1');
                    }
                });
            }
        })

    });
})(jQuery);