/************* collapse button in panel***************8*/
        $(document).on('click', '.card .tools .t-collapse', function() {
            var el = $(this).parents(".card").children(".card-body");
            if ($(this).hasClass("fa-chevron-down")) {
                $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
                el.slideUp(200);
            } else {
                $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
                el.slideDown(200);
            }
        });

        /**************** close button in panel *****************/
        $(document).on('click', '.card .tools .t-close', function() {
            $(this).parents(".card").remove();
        });

        /****************** refresh button in panel *****************/
        $(document).on('click', '.card .tools .box-refresh', function(br) {
            br.preventDefault();
            $("<div class='refresh-block'><span class='refresh-loader'><i class='fas fa-circle-notch fa-spin'></i></span></div>").appendTo($(this).parents('.tools').parents('.card-header').parents('.card'));
            setTimeout(function() {
                $('.refresh-block').remove();
            }, 1000);
        });

     