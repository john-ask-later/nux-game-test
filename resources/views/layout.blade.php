<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Nux gaming test</title>

    <!-- Styles / Scripts -->
    <script>
        window.app = {
            csfr: '{{ csrf_token() }}',
            url: {
                home: '{{ route('home') }}'
            },
            messages: {
                lp_expired: 'Sorry, but page you are want to interact with now available any more.'
            }
        }
    </script>

    @vite(['resources/js/app.js', 'resources/scss/app.scss'])
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 mx-auto pt-5">

            @yield('content')

        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/3b47bd1f5b.js" crossorigin="anonymous"></script>

</body>
</html>
