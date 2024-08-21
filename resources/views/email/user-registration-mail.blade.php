<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- <!-- SITE TITLE -->
    <title>Acount Activation | Dharma Ideal Campaign</title>

    <link href="https://fonts.googleapis.com/css?family=Expletus+Sans:600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> --}}

    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
    }

    h4,
    h6 {
        font-size: 14px;
        font-weight: 100;
        font-family: 'Times New Roman', 'Segoe UI' !important;
    }
    </style>
</head>

<body>
    <div>
        {{-- <div style="background: #2e2e2e; color:#fff;padding: 10px;text-align:center;margin:20px 0px;font-size: 18px;font-weight: bold;letter-spacing: 1px;">
        <span>User Registration</span>
    </div> --}}
        <div style="padding: 15px;letter-spacing: 0.2px;">

            <p>Dear {{ $name}},</p>

            @if ($form_type=='membership')
            <p>Congratulations! You have successfully registered for Dharma Ideal Sponsor Membership on our platform. We are excited to welcome you to our community.</p>
            <b><p>Registration Details</p></b>
            <p>
                <b>Full Name:</b> {{ucwords($name)}} <br>
                <b>Phone:</b> {{$phone}} <br>
                <b>Email:</b> {{$email}} <br>
                <b>Sex:</b> {{ucwords($sex)}} <br>
                <b>Religion:</b> {{ucwords($religion)}} <br>
                <b>Membership Duration:</b> {{ucwords($membership_duration)}} <br>
                <b>Country:</b> {{ucwords($country)}} <br>
                <b>State:</b> {{ucwords($state)}} <br>
                <b>City:</b> {{ucwords($city)}} <br>
                <b>Street:</b> {{ucwords($street)}} <br>
                <b>Zip Code:</b> {{$zip_code}} <br>
                <b>Occupation:</b> {{ucwords($occupation)}} <br>
                <b>Qualification:</b> {{ucwords($qualification)}} <br>

            </p>
            @foreach ($family_member as $key => $value)
                
            <p>Family Member {{$key+1}}</p>
            <p>
                <b>Full Name:</b> {{ucwords($value['full_name'])}} <br>
                <b>Sex:</b> {{ucwords($value['sex'])}} <br>
                <b>Religion:</b> {{ucwords($value['religion'])}} <br>
                <b>Phone:</b> {{$value['phone']}} <br>
                <b>Occupation:</b> {{ucwords($value['occupation'])}} <br>
                <b>Family Relation:</b> {{ucwords($value['family_relation'])}} <br>
            </p>
            @endforeach
            @endif

            @if ($form_type=='donor')
            <p>Congratulations! You have successfully registered for Dharma Ideal Donor on our platform.</p>
            <b><p>Registration Details</p></b>
            <p>
                <b>Full Name:</b> {{ucwords($name)}} <br>
                <b>Phone:</b> {{$phone}} <br>
                <b>Email:</b> {{$email}} <br>
                <b>Sex:</b> {{ucwords($sex)}} <br>
                <b>Religion:</b> {{ucwords($religion)}} <br>
                <b>Country:</b> {{ucwords($country)}} <br>
                <b>State:</b> {{ucwords($state)}} <br>
                <b>City:</b> {{ucwords($city)}} <br>
                <b>Street:</b> {{ucwords($street)}} <br>
                <b>Zip Code:</b> {{$zip_code}} <br>
                <b>Amount:</b> {{$currency.' '.$amount}} <br>
                <b>Payment Method:</b> {{ucwords($payment_method)}} <br>
                <b>Payment Status:</b> {{ucwords($payment_status)}} <br>
              

            </p>
            <p><b>Donation Detail:</b></p>
            <p>
            @foreach ($donation as $d_key => $d_value)
                
              <b>{{@$d_key+1}}. {{ucwords($d_value['name'])}}</b>  <br>
               
              @endforeach
            </p>
            @endif



            <br><br>
            <p>Sincerely Yours,<br>Dharma Ideal Campaign</p>
            <!-- <p></p> -->
            <!-- <p>Message Recieved on {{ now() }}
            <p><br> -->

        </div>
    </div>
</body>

</html>