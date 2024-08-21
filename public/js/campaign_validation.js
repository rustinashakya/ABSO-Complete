
$(function() {
var youtube = $("#youtube").val();
        if(youtube == 'youtube') {
                $(".youtube_div").show();
                $(".image_div").hide();
        }

        $('#type_div').on('change', function(){
            var demovalue = $(this).val();
            $("div.myDiv").hide();
            $("#show"+demovalue).show();
        });

        $(".save-button").click(function( event ) {
            var image = $('select#type_div').find(':selected').data('image');
            if(image == 'image') {
                var mobile_image = $('.mobile_image').val();
                var main_image = $('.main_image').val();
                var title = $('.title').val();
                var pdf_file = $('.pdf_file').val();
                $( "#mobile_image_error" ).text('');
                $( "#main_image_error" ).text('');
                $( "#title_error" ).text('');
                $( "#pdf_file_error" ).text('');
                $( "#required_title" ).text('');
                $( "#required_mobile_image" ).text('');
                $( "#required_main_image" ).text('');
                $( "#required_pdf" ).text('');

                if(mobile_image == '' && main_image == '' && title == '' && pdf_file == '') {
                $( "#mobile_image_error" ).text( "Mobile Image field is required." ).show();
                $( "#main_image_error" ).text( "Main Image field is required." ).show();
                $( "#title_error" ).text( "Title field is required." ).show();
                $( "#pdf_file_error" ).text( "Pdf file field is required." ).show();
                return false;
                }
                if(mobile_image == '' && main_image == '' && pdf_file == '') {
                $( "#mobile_image_error" ).text( "Mobile Image field is required." ).show();
                $( "#main_image_error" ).text( "Main Image field is required." ).show();
                $( "#pdf_file_error" ).text( "Pdf file field is required." ).show();
                return false;
                }
                if(mobile_image == '' && main_image == '' && title == '') {
                $( "#mobile_image_error" ).text( "Mobile Image field is required." ).show();
                $( "#main_image_error" ).text( "Main Image field is required." ).show();
                $( "#title_error" ).text( "Title field is required." ).show();
                return false;
                }
                if(mobile_image == '' && pdf_file == '' && title == '') {
                $( "#mobile_image_error" ).text( "Mobile Image field is required." ).show();
                $( "#title_error" ).text( "Title field is required." ).show();
                $( "#pdf_file_error" ).text( "Pdf file field is required." ).show();
                return false;
                }
                if(main_image == '' && pdf_file == '' && title == '') {
                $( "#main_image_error" ).text( "Main Image field is required." ).show();
                $( "#pdf_file_error" ).text( "Pdf file field is required." ).show();
                $( "#title_error" ).text( "Title field is required." ).show();
                return false;
                }
                if(mobile_image == '' && main_image == '') {
                $( "#mobile_image_error" ).text( "Mobile Image field is required." ).show();
                $( "#main_image_error" ).text( "Main Image field is required." ).show();
                return false;
                }
                if(mobile_image == '' && title == '') {
                $( "#mobile_image_error" ).text( "Mobile Image field is required." ).show();
                $( "#title_error" ).text( "Title field is required." ).show();
                return false;
                }
                if(main_image == '' && title == '') {
                $( "#main_image_error" ).text( "Main Image field is required." ).show();
                $( "#title_error" ).text( "Title field is required." ).show();
                return false;
                }
                if(mobile_image == '') {
                $( "#mobile_image_error" ).text( "Mobile Image field is required." ).show();
                return false;
                }
                if(main_image == '') {
                $( "#main_image_error" ).text( "Main Image field is required" ).show();
                return false;
                }
                if(title == '') {
                $( "#title_error" ).text( "Title field is required" ).show();
                return false;
                
                }
                } 
        // alert( "Handler for .submit() called." );
        // event.preventDefault();
        });

        
        // $("#image").change(function(){
        //     if(image == 'image') {
        //             console.log(1);
        //         $("#image_div").show();
        //         $("#youtube_div").hide();
        //     }
        //     });
    });