<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
    
    (function () {
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
        @if(Auth::check())
            window.authUser={!! Auth::user() !!}
            @else
            window.authUser=false
            @endif
    })();
    </script>
</head>
<body>
    <div id="app"> 
            <z-dashboard></z-dashboard>
    </div>
</body>
</html>
