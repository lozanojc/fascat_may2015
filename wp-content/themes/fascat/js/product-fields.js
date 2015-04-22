jQuery(document).ready(function($){
    if('undefined' !== typeof fsVals){
        var input;
        $.each(fsVals.vals, function(i, v){
            input = $('input[name="' + i + '"]');
            //console.log(input.length);
            if(0 < input.length){
                //console.log(input.attr('type'));
                if('checkbox' === input.attr('type')){
                    input.filter('[value="' + v + '"]').prop("checked","true");
                }
                else{
                    input.val(v);
                }
            }
            //console.log(i + ' ' + v);
        });
        if('undefined' !== typeof(fsVals.error)){
            input = $('input[name="' + fsVals.error + '"]');
            if(0 < input.length){
                input.focus();
            }
        }
    }

    $('.wpcf7-exclusive-checkbox').find(':checkbox').click(function(){
        if($(this).prop('checked')){
            $(this).parents('.wpcf7-list-item').siblings('.wpcf7-list-item').find(':checkbox').prop('checked', false);
        }
    });
    $('.wpcf7-list-item-label').click(function(e){
        $(this).prev(':checkbox').click();
    });

    if(0 < $('.woocommerce-message,.woocommerce-error').length){
        $('html,body').animate({
            scrollTop: $('.woocommerce-message,.woocommerce-error').offset().top
        }, 1000);
    }
    
    //console.log($('.training_black').length);

    $('.training_black').click(function(){
        $(this).siblings('.training_black.active').removeClass('active').find('i.fa').removeClass('fa-check-square').addClass('fa-square-o');;
        $(this).toggleClass('active').find('i.fa').toggleClass('fa-square-o').toggleClass('fa-check-square');
        $('#chosen_coach').val($(this).hasClass('active') ? $(this).find('.coach_name').text() : '');
    });

    var coach = $('#chosen_coach').val();
    if('undefined' !== typeof(coach) && '' !== coach){
        $('#choose_coach').find('.coach_name').each(function(){
            if(coach === $(this).html()){
                $(this).parents('.training_black').click();
                return false;//break
            }
        });
    }
});
