<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    {{-- <!-- SITE TITLE -->
    <title>Hope Fertility and Diagnostic Centre</title>

    <link href="https://fonts.googleapis.com/css?family=Expletus+Sans:600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> --}}

    <style>
        body{
            font-family: 'Segoe UI', sans-serif;
        }
        h4,h6{
            font-size: 14px;
            font-weight: 100;
            font-family: 'Times New Roman','Segoe UI' !important;
        }
    </style>
</head>

<body>
<div>
    {{-- <div style="background: #2e2e2e; color:#fff;padding: 10px;text-align:center;margin:20px 0px;font-size: 18px;font-weight: bold;letter-spacing: 1px;">
        <span>Enquiry via Contact Form</span>
    </div> --}}
    <div style="padding: 15px;letter-spacing: 0.2px;">
        <p>Dear Admin,</p>
        <p>The Following Appointment has been booked by {{ucwords($name)}}</p>
            <b><p>Appointment Details</p></b>
                    <p>
                        Consultant Doctor: {{ucwords($doctor_name)}} <br>
                        Appointment Date: {{$appointment_date}} <br>
                        Appointment Time: {{$appointment_time}} <br>
                        Consultancy Fee: Rs. {{ucwords($fee)}} <br> 
                        Payment Method: {{ucwords($payment_method)}} <br> 
                        Payment Status: Paid <br>
                        Transaction id: {{$transaction_no}} <br>
                    </p>
                    <b><p>Patient's Details</p></b>
                    <p>
                        Full Name: {{ucwords($name)}} <br>
                        Email: {{$email}} <br>
                        Phone: {{$phone}} <br>
                        Sex: {{ucwords($sex)}} <br>
                        Date of Birth: {{$dob}} <br>
                        Country: {{ucwords($country_name)}} <br>
                        Province: {{ucwords(@$province_name)}} <br>
                        City: {{ucwords($city)}} <br>
                        Street: {{ucwords($street)}} <br><br>
                        Note: {{$note}} <br>
                        <!-- <b>Payment Method:</b> {{ucwords($payment_method)}} <br> 
                        <b>Payment Status:</b> Pe <br>
                        <b>Payment Status:</b> Unpaid <br>
                        <b>Payment Status:</b> Unpaid <br> -->


                    </p>
                    <br><br>
                    <b><p>Sincerely Yours,<br>Hope Fertility And Diagnostic</p></b>
    </div>
</div>
</body>
</html>
