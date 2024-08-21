$(function(){

    // $(document).on('change','.js-ch-v',function(){
    //     var val = $(this).val()
    //     if(val!==''){
    //         $('.js-collapse-ch').addClass('active')
    //         $(document).find('body').addClass('sidebar-collapse')
    //     }
    //     else {
    //         $('.js-collapse-ch').removeClass('active')
    //         $(document).find('body').removeClass('sidebar-collapse')
    //     }
    // })
    $(document).on('click','.js-close-ch',function(){
        $('.js-my-ch-select div:first-child').trigger('click')
    })
    $(document).on('click','.js-my-selected',function(){
        var _this = $(this)
        if(_this.hasClass('active')){
            $('.js-my-ch-select').hide()
            _this.removeClass('active')
        }
        else {
            $('.js-my-ch-select').show()
            _this.addClass('active')
        }
    })
    // $(document).on('click','.js-my-ch-select div',function(){
    //     var _this = $(this)
    //     var value = _this.data('value')
    //     if(value!==''){
    //         $('.js-collapse-ch').addClass('active')
    //         $(document).find('body').addClass('sidebar-collapse')
    //         $('.new-ch-wrap').addClass('active')
    //         $('.js-ch-title-person').addClass('active')
    //     }
    //     else {
    //         $('.js-collapse-ch').removeClass('active')
    //         $(document).find('body').removeClass('sidebar-collapse')
    //         $('.new-ch-wrap').removeClass('active')
    //         $('.js-ch-title-person').removeClass('active')
    //     }
    //     if(!_this.hasClass('active')){
    //         $('.js-my-ch-select').find('.active').removeClass('active')
    //         _this.addClass('active')
    //     }
    //     $('.js-my-selected').removeClass('active').html(_this.html())
    //     $('.js-my-ch-select').hide()
    // })

    var specifiedElement = document.getElementById('testDiv');
    document.addEventListener('click', function(event) {
        var isClickInside = specifiedElement.contains(event.target);
        if (!isClickInside) {
            $('.js-my-ch-select').hide()
            $('.js-my-selected').removeClass('active')
        }
    });
})
