//Isotop Projects

        window.onresize = function(event) {
            $('#gallery').isotope('reLayout');
        };

        $(window).load(function() {
            // --------------------------------------------------
            // filtering gallery
            // --------------------------------------------------
            var $container = $('#gallery');
            $container.isotope({
                itemSelector: '.item',
                filter: '*'
            });

            $('#filter a').on('click',function() {
                var $this = $(this);
                if ( $this.hasClass('current') ) {
                    return false;
                    }
                var $optionSet = $this.parents();
                $optionSet.find('.current').removeClass('current');
                $this.addClass('current');
                        
                var selector = $(this).attr('data-filter');
                $container.isotope({ 
                    filter: selector,
                });
                return false;
            });

        });