    function sumIncome() {
        var pdf = '?pdf=pdf';
        const customer = document.getElementById("customer_id");
        var customer_id = customer.value;
        var url = "{{ url('/my-ticket/') }}";
        var route = url + '/' + customer_id + pdf;
        $.ajax({
            type: "GET",
            url: route,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                $(document).find('span.error-text').text('');
            },
            success: function(data) {
                if (data.status == 400) {
                   alert(1)
                } else {
                    alert(2)
                }
            },
            error: function(data) {},
        });
        
    }