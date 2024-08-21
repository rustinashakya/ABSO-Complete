    $(document).ready(function($) {

        fetchCustomer();

        //Get customer detail
        function fetchCustomer() {
            var count = 1;
            $.ajax({
                type: "GET",
                url: "/get/ticket/type",
                dataType: "json",
                success: function(response) {
                    $('tbody').html("");
                    $.each(response.customer_type, function(key, value) {
                        if (value.trip_type == 'single_trip') {
                            var trip = 'Single Trip';
                        } else {
                            var trip = 'Round Trip';
                        }
                        $('tbody').append('<tr>\
                                                <th scope="row">' + count++ + '</th>\
                                                <td>' + value.nationality_type + '</td>\
                                                <td>' + value.age_group + '</td>\
                                                <td>' + trip + '</td>\
                                                <td>' + value.rate + '</td>\
                                                <td class="d-inline-flex">\
                                                <button type="button" value="' + value.id + '" class="customer_edit btn btn-primary btn-sm fas fa-edit"></button>\
                                                    &nbsp;\
                                                <button type="button" value="' + value.id + '" class="customer_delete btn btn-danger btn-sm fa fa-trash"></button>\
                                                </td>\
                                            </tr>');
                    });
                }
            });
        }

        // CREATE
        $(document).on('click', '.btn-save', function(e) {
            e.preventDefault();
            if ($('input[name=trip]:checked', '#form_trip').val() == "single_trip") {
                var trip = $('#form_trip').find(':radio[name=trip][value="single_trip"]')
                    .prop('checked', true); // #trip is  name  of the  RB
                var trip = $('#form_trip').find(':radio[name=trip][value="round_trip"]').prop(
                    'checked', false);
            } else {
                var trip = $('#form_trip').find(':radio[name=trip][value="round_trip"]').prop(
                    'checked', true);
                var trip = $('#form_trip').find(':radio[name=trip][value="single_trip"]')
                    .prop('checked', false);
            }

            var data = {
                nationality_type: $('#nationality_type').val(),
                rate: $('#rate').val(),
                age_group: $('#age_group').val(),
                trip: $('input[name=trip]:checked', '#form_trip').val(),
            }
            $.ajax({
                type: "POST",
                url: "/admin/ticket/type/store",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 400) {
                        $.each(data.error, function(key, value) {
                            $('span.' + key + '_error').text(value[0]);
                        });
                    } else {
                        $("#success_message").addClass('alert alert-success')
                        $("#success_message").text(data.message)
                        $("#exampleModalCenter").modal('hide');
                        $("#exampleModalCenter").find('input').val("");
                        $("[name=trip]").removeAttr("checked");
                        $("#success_message").fadeOut(5000);
                        fetchCustomer();
                    }
                },
                error: function(data) {},
            });
        });

        //edit
        $(document).on('click', '.customer_edit', function(e) {
            e.preventDefault();
            var customer_id = $(this).val();
            $("#editCustomerModal").modal("show")
            $.ajax({
                type: "GET",
                url: "/admin/ticket/type/edit/" + customer_id,
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(key, value) {
                            $('span.' + key + '_error').text(value[0]);
                        });
                    } else {
                        var checked_value = response.message.trip_type;
                        if ($(".form-check").find('[name="trip_edit"]').is(":checked") ===
                            false) {
                            $(".form-check")
                                .find('[name="trip_edit"]')
                                .filter("[value=" + checked_value + "]")
                                .prop("checked", true);

                        }

                        // if (response.message.trip_type == "single_trip") {
                        //     $('.form-check').find(':radio[name=trip][value="single_trip"]')
                        //         .prop('checked', true); // #trip is  name  of the  RB
                        //     $('.form-check').find(':radio[name=trip][value="round_trip"]').prop(
                        //         'checked', false);
                        // } else {
                        //     $('.form-check').find(':radio[name=trip][value="round_trip"]').prop(
                        //         'checked', true);
                        //     $('.form-check').find(':radio[name=trip][value="single_trip"]')
                        //         .prop('checked', false);
                        // }

                        $("#edit_nationality_type").val(response.message.nationality_type)
                        $("#edit_age_group").val(response.message.age_group)
                        $("#edit_rate").val(response.message.rate)
                        $(".edit_trip").val(response.message.trip_type)
                        $("#edit_customer_type").val(customer_id)
                    }
                }
            });
            // on("hide", function() {
            //     window.setTimeout(function() {
            //         $("#editCustomerModal").modal("hide");
            //         location.reload();
            //     });
            // });
        });

        //update
        $(document).on('click', '.btn-update', function(e) {
            e.preventDefault();
            // if ($("input[type='radio'].edit_trip").is(':checked')) {
            //         var trip = $("input[type='radio'].edit_trip:checked").val();
            //         // console.log(trip);
            //     }
            var customer_id = $("#edit_customer_type").val();
            var trip = $('.edit_trip').val();
            var data = {
                nationality_type: $('#edit_nationality_type').val(),
                rate: $('#edit_rate').val(),
                age_group: $('#edit_age_group').val(),
                trip: trip,
            }
            $.ajax({
                type: "PUT",
                url: "/admin/ticket/type/update/" + customer_id,
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 400) {
                        $.each(data.error, function(key, value) {
                            $('span.' + key + '_errors').text(value[0]);
                        });
                    } else {
                        $("#success_message").addClass('alert alert-success')
                        $("#success_message").text(data.message)
                        $("#editCustomerModal").modal('hide');
                        $("#editCustomerModal").find('input').val("");
                        $("#success_message").fadeOut(5000);
                        fetchCustomer();
                    }
                },
            });
        });

        //delete
        $(document).on('click', '.customer_delete', function(e) {
            e.preventDefault();
            var customer_id = $(this).val();
            console.log(customer_id);
            $('#delete_customer_type').val(customer_id);
            $("#deleteCustomerModal").modal("show");
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var customer_id = $('#delete_customer_type').val();
            $.ajax({
                type: "DELETE",
                url: "/admin/ticket/type/delete/" + customer_id,
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        $("#success_message").addClass('alert alert-danger')
                        $("#success_message").text(response.message)
                        $("#deleteCustomerModal").modal('hide');
                        $("#success_message").fadeOut(5000);
                        fetchCustomer();
                    }
                }
            });
        });
    });
    //end of document ready