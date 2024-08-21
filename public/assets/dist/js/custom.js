$(function(){
    function addIcon(option) {
        // console.log('asdf',option)
        var baseUrl = "/user/pages/images/flags";
        return $('<span><i class="fa fa-file"></i>' +
                  option.text + '</span>');
      }
	$('.js-select2-single').select2({
		width: '100%',
	})
	$('.js-select2-multiple').select2({
		width: '100%',
		placeholder: 'Choose option',
    })
	$('.js-select2-single-cv').select2({
        width: '100%',
        templateSelection: addIcon
	})
})
