<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="robots" content="noindex">
        <meta charset="utf-8">

        <!-- Title -->
        <title>Arrow | @yield('title') </title>
         
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Stylesheet -->
        <link href="{{ url('css/bootswatch.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">

        <!-- Favicon -->
        <link rel="icon" href="{{ url('images/favicon.ico') }}">
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
        
        <script>
                window.Laravel = <?php echo json_encode([
                    'csrfToken' => csrf_token(),
                ]); ?>;
                const DASHBOARD_USER_ID = '{{ Auth::user()->id }}';
                const DASHBOARD_USER_FIRST = '{{ Auth::user()->first }}';
                const DASHBOARD_USERS_NAME = '{{ Auth::user()->first . ' ' . Auth::user()->last }}';
                const DASHBOARD_USER_PERMISSIONS = '{{ Auth::user()->permissions }}';
                const DASHBOARD_USER_EMAIL = '{{ Auth::user()->email }}';
                const DASHBOARD_USER_COMPANY = '{{ Auth::user()->company_name }}';
                const DASHBOARD_USER_GST = '{{ Auth::user()->gst_number }}';
                const DASHBOARD_USER_HOURLY = '{{ Auth::user()->hourly_rate_one }}';

        </script>
    </head>

    <body>

    <div id="app">     

        <app-hub></app-hub>

    </div>

        <!-- Script -->
        <script src="{{ url('js/app.js') }}"></script>
    </body>

</html>