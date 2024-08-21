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

            <p>Dear {{ ucwords($name) }},</p>

            <p>Thank you for reaching out to us!.</p><br>
            <p>
                We have received your message and our team will get back to you as soon as possible. Below is a summary
                of your submission:
            </p>
            <br>
            <p>
                Name: <b>{{ ucwords($name) }}</b>
            </p>
            <p>
                Email: <b>{{ $email }}</b>
            </p>
            <p>
                Subject: {{ $subjectssss }}
            </p>
            <p>
                Message: {{ $content }}
            </p>

            <br><br>
            <b>
                <p>Sincerely Yours ,<br>{{ ucwords($company_name) }}</p>
            </b>

        </div>
    </div>
</body>

</html>
