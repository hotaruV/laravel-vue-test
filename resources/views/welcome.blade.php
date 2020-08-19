<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="shortcut icon" href="{{asset('dist/img/favicon.png')}}">
    <title>Gestion de usuarios con vue</title>
    <!-- Icons -->
    <link href="{{asset('dist/css/app.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{csrf_token()}}">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
        <usuarios-component></usuarios-component>
    </div>


    <!-- Bootstrap and necessary plugins -->
    <script src="{{asset('dist/js/vueComponents.js')}}"></script>
    <script src="{{asset('dist/js/app.js')}}"></script>

</body>

</html>
