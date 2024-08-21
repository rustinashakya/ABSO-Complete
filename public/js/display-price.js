        $(function() {
            $("select#nationality_type").change(displayTotalPrice);
            displayTotalPrice();
        });
        $(function() {
            $("select#age_group").change(displayTotalPrice);
            displayTotalPrice();
        });
        $(function() {
            $("input#trip2").change(displayTotalPrice);
            displayTotalPrice();
        });
        $(function() {
            $("input#trip1").change(displayTotalPrice);
            displayTotalPrice();
        });
        $(function() {
            $("input#quantity").change(displayTotalPrice);
            displayTotalPrice();
        });
        console.log(123)

        function displayTotalPrice() {
            var data = {
                nationality_type: $('#nationality_type').val(),
                age_group: $('#age_group').val(),
                quantity: $('#quantity').val(),
                trip: $('input[name=trip]:checked').val(),
            }
            $.ajax({
                type: "POST",
                url: "/display/total-price",
                data: data,
                dataType: 'json',
                success: function(data) {
                    $('#get_total_price').empty();
                    $('#get_total_price').append(data.display_total_price);
                }
            });
        }