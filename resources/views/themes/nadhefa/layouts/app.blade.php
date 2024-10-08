<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('build/assets/app-<hash>.css') }}">
  <script type="module" src="{{ asset('build/assets/app-<hash>.js') }}"></script>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <title>Nadhefa Store</title>

  @vite([
    'resources/sass/app.scss',
    'resources/js/app.js',
 
    'resources/views/themes/nadhefa/assets/css/main.css',
    'resources/views/themes/nadhefa/assets/plugins/jqueryui/jquery-ui.css',

    'resources/views/themes/nadhefa/assets/js/main.css',
    'resources/views/themes/nadhefa/assets/plugins/jqueryui/jquery-ui.min.css',
  ])
</head>

<body>
  @include('themes.nadhefa.share.header')
  @yield('content')
  @include('themes.nadhefa.share.footer')

  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
</body>

</html>