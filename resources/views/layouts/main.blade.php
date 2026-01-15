<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-head/>
<body>
    <!-- WRAPPER -->
    <div class="wrapper">
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
