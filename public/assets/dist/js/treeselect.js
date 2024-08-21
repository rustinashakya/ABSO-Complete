$(function(){
    $(document).on('change','.js-ch-v_',function(){
        var val = $(this).val()
        if(val!==''){
            $('.js-collapse-ch_').addClass('active')
        }
        else {
            $('.js-collapse-ch_').removeClass('active')
        }
    })

    $(document).on('click','.js-my-selected_',function(){
        var _this = $(this)
        if(_this.hasClass('active')){
            $('.js-my-ch-select_').hide()
            _this.removeClass('active')
        }
        else {
            $('.js-my-ch-select_').show()
            _this.addClass('active')
        }
    })
    $(document).on('click','.js-my-ch-select_ .leaf',function(){
        var _this = $(this)
        var value = _this.data('value')
        if(value!==''){
            $('.js-collapse-ch_').addClass('active')
            $('.new-ch-wrap_').addClass('active')
            $('.js-ch-title-person').addClass('active')
        }
        else {
            $('.js-collapse-ch_').removeClass('active')
            $('.new-ch-wrap_').removeClass('active')
            $('.js-ch-title-person').removeClass('active')
        }
        if(!_this.hasClass('active')){
            $('.js-my-ch-select_').find('.active').removeClass('active')
            _this.addClass('active')
        }
        $('.js-my-selected_').removeClass('active').html(_this.html()).attr("data-value",value)
        $('.js-my-ch-select_').hide()
        $('.js-my-search-input').val('')
        $('.js-options').html(oldhtmloptions)
        getLocalbodies(value)
    })

    var specifiedElement = document.getElementById('testDivNew');
    document.addEventListener('click', function(event) {
        var isClickInside = specifiedElement.contains(event.target);
        if (!isClickInside) {
            $('.js-my-ch-select_').hide()
            $('.js-my-selected_').removeClass('active')
        }
    });

    $(document).on('keyup','.js-my-search-input',function(e){
        var value = $(this).val()
        if (e.keyCode == 8 || e.keyCode == 46) {
            $('.js-options').html(oldhtmloptions)
        }
        if(value === ''){
            $('.js-options').html(oldhtmloptions)
        }else {
            $( ".js-options .leaf" ).each(function( index ) {
                var _this = $(this)
                // var text = _this.text().split('')
                var text = _this.text()
                if( !text.includes(value) ){
                    _this.remove()
                }
            });
        }
    })
})
