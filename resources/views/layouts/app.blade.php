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
                const dashboard_users_name = '{{ Auth::user()->first . ' ' . Auth::user()->last }}';
                const dasboard_users_permissions = '{{ Auth::user()->permissions }}';
        </script>
    </head>

    <body>

    <div id="app">     

        <div class="container">
            <navbar>
                <li class="{{ ((Request::is('app')) ? 'active' : '' ) }}"><a href="/app">Dashboard</a></li>
                <li class="{{ ((Request::is('app/users')) ? 'active' : '' ) }}"><a href="/app/users">Users</a></li>
                <li class="{{ ((Request::is('app/projects')) ? 'active' : '' ) }}"><a href="/app/projects">Projects</a></li>
            </navbar>

            @yield('content')

        </div>

    </div>

        <!-- Script -->
        <script src="{{ url('js/app.js') }}"></script>
    </body>

</html>