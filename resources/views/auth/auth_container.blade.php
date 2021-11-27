<!doctype html>
<html lang="en">
<head>
    <title>Login - {{config('app.name')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('/auth_res') }}/css/style.css">

    <style>
        /* The alert message box */
        .alert {
            padding: 20px;
            background-color: #f44336; /* Red */
            color: white;
            margin-bottom: 15px;
        }

        .alert-success {
            padding: 20px;
            background-color: lightgreen; /* Green */
            color: white;
            margin-bottom: 15px;
        }

        /* The close button */
        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        /* When moving the mouse over the close button */
        .closebtn:hover {
            color: black;
        }
    </style>

</head>
<body>
<section class="ftco-section">
    @yield('content')
</section>

<script src="{{ asset('/auth_res') }}/js/jquery.min.js"></script>
<script src="{{ asset('/auth_res') }}/js/popper.js"></script>
<script src="{{ asset('/auth_res') }}/s/bootstrap.min.js"></script>
<script src="{{ asset('/auth_res') }}/js/main.js"></script>

</body>
</html>

