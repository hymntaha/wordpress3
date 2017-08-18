jQuery(document).ready(function($) {

    $(".fancybox")
        .attr('rel', 'gallery')
        .fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            nextEffect  : 'none',
            prevEffect  : 'none',
            padding     : 0,
            margin      : 50,
            beforeShow  : function() {
                // Find the iframe ID
                var id = $.fancybox.inner.find('iframe').attr('id');

                // Create video player object and add event listeners
                var player = new YT.Player(id, {
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            },
            helpers: {
                overlay: {
                    locked: false
                }
            }
        });

    // Fires whenever a player has finished loading
    function onPlayerReady(event) {
        event.target.playVideo();
    }

    // Fires when the player's state changes.
    function onPlayerStateChange(event) {
        // Go to the next video after the current one is finished playing
        if (event.data === 0) {
            $.fancybox.next();
        }
    }

    //Fire slick slider
    run_slick_slider();

    function run_slick_slider() {
        // This is for slick.js
        jQuery('.slider').slick({
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 5,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                }
            ]
        });
    }

    /**
     * Library fire isotope and multiselect
     */

    var multiSelectOptions = {
        numberDisplayed: 1,
        onChange: _.debounce(function() {
            setupFilterBtn();
            getLibraryItemsData(1).done(function(data){
                //Check if all element are selected and setup proper text/ reset filter btn
                //First remove all isotop items
                var items = $('#library-items').find('.grid-item');

                appendIsotopItems(data);

                $('#library-items').isotope('remove', items).isotope('layout');

                setupLoadMoreButton(data, 1);

                if (!data.blocks.length) {
                    $('#msg-box').show();
                    $('#load-more').hide();
                } else {
                    $('#msg-box').hide();
                }
            })
        }, 500)
    };

    if ($('.geekout-library').length) {
        $('#industry').multiselect(multiSelectOptions);
        $('#audienceProfile').multiselect(multiSelectOptions);
        $('#contentType').multiselect(multiSelectOptions);
        $('#datePublished').multiselect(multiSelectOptions);

        //Bind multiselector reset
        $('.reset-filters').on('click', function (event) {
            event.preventDefault();

            $('.geekout-library select option:selected').each(function(){
                $(this).prop('selected', false);
            });

            $('.geekout-library select').multiselect('refresh');

            setupFilterBtn();

            //Reload items result
            getLibraryItemsData(1).done(function(data){
                var libraryContainer = $('#library-items');
                var items = libraryContainer.find('.grid-item');

                libraryContainer.isotope('remove', items).isotope('layout');

                appendIsotopItems(data);
                setupLoadMoreButton(data, 1);
            });
        });


        // Isotope
        $('#library-items').isotope({
          // options
          itemSelector: '.grid-item',
          layoutMode: 'fitRows'
        });

        //Bind load more button
        $('#load-more > span').on('click', function (event) {
            event.preventDefault();
            var loadMoreButton = $(this);
            var page = parseInt(loadMoreButton.data('current-page'));
            var newPageNumber = page + 1;

            getLibraryItemsData(newPageNumber).done(function(data){
                appendIsotopItems(data);

                setupLoadMoreButton(data, newPageNumber);
            });
        })
    }

    function setupFilterBtn() {
        var selectedOptionNumber = $('.geekout-library select option:selected').length;

        if (selectedOptionNumber) {
            $('.geekout-nav-buttons .default-text').addClass('hidden');
            $('.geekout-nav-buttons .reset-filters').removeClass('hidden');
        } else {
            $('.geekout-nav-buttons .default-text').removeClass('hidden');
            $('.geekout-nav-buttons .reset-filters').addClass('hidden');
        }
    }

    function setupLoadMoreButton(data, newPageNumber)
    {
        var loadMoreButton = $('#load-more > span');

        if (newPageNumber >= data.max_num_page) {
            loadMoreButton.hide();
        } else {
            loadMoreButton.show();
        }

        loadMoreButton.data('current-page', newPageNumber);
    }

    function appendIsotopItems(data)
    {
        for(var i in data.blocks) {
            var item = $(data.blocks[i]);
            $('#library-items').append(item)
            $('#library-items').isotope('appended', item);
        }
    }

    function getLibraryItemsData(page)
    {
        //Prepeare data filters
        selectedOptions = $('.geekout-library .select option:selected');
        requestData = $('#library-filters').serialize();

        return $.ajax({
            method: 'GET',
            url: ajaxurl,
            cache: false,
            dataType: 'json',
            data: {
                'action': 'search_library_items',
                'data': requestData,
                'page': page,
            }
        });
    }

    /***
     * Scroll animation/geekout/scrollTo homepage
     */

    $('a[href="#next-section"]').on('click', function(){
        var offset = $("#next-section").offset();
        if ($(window).width() >= 768) {
            $("html,body").animate({
                scrollTop: offset.top - 75
            }, 500);
        } else if ($(window).width() < 767) {
            $("html,body").animate({
                scrollTop: offset.top - 55
            }, 500);
        }
    });

    $('a[href="#library"]').on('click', function(){
        var offset = $("#library").offset();
        if ($(window).width() >= 768) {
            $("html,body").animate({
                scrollTop: offset.top - 75
            }, 500);
        } else if ($(window).width() < 767) {
            $("html,body").animate({
                scrollTop: offset.top - 55
            }, 500);
        }
    });

    $('a[href="#research"]').on('click', function(){
        var offset = $("#research").offset();
        if ($(window).width() >= 768) {
            $("html,body").animate({
                scrollTop: offset.top - 75
            }, 500);
        } else if ($(window).width() < 767) {
            $("html,body").animate({
                scrollTop: offset.top - 55
            }, 500);
        }
    });

    $('a[href="#transit"]').on('click', function(){
        var offset = $("#transit").offset();
        if ($(window).width() >= 768) {
            $("html,body").animate({
                scrollTop: offset.top - 75
            }, 500);
        } else if ($(window).width() < 767) {
            $("html,body").animate({
                scrollTop: offset.top - 55
            }, 500);
        }
    });

    $('a[href="#oOH"]').on('click', function(){
        var offset = $("#oOH").offset();
        if ($(window).width() >= 768) {
            $("html,body").animate({
                scrollTop: offset.top - 75
            }, 500);
        } else if ($(window).width() < 767) {
            $("html,body").animate({
                scrollTop: offset.top - 55
            }, 500);
        }
    });

    /**
     * Datatables
     */
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    });

    //Load data for members tabs
    $('.our-members table.table').each(function(){
        var catSlug = $(this).data('items-cat');

        if (!catSlug) {
            return;
        }

        $(this).DataTable( {
            ajax:           {
                url: ajaxurl,
                type: 'GET',
                data: {
                    action: 'members_type_items',
                    cat_slug: catSlug
                }
            },
            scrollY:        200,
            scrollCollapse: true,
            paging:         true,
            iDisplayLength: 25
        });
    });

    //Load data for board tabs
    $('.our-board table.table').each(function(){
        var catSlug = $(this).data('items-cat');

        if (!catSlug) {
            return;
        }

        $(this).DataTable( {
            ajax:           {
                url: ajaxurl,
                type: 'GET',
                data: {
                    action: 'board_type_items',
                    cat_slug: catSlug
                }
            },
            scrollY:        200,
            scrollCollapse: true,
            paging:         true,
            iDisplayLength: 25
        });
    });
});