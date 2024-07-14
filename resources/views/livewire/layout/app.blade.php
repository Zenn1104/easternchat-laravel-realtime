<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-base-200 dark:bg-gray-900">
            {{-- <livewire:layout.navigation /> --}}

            <!-- Page Content -->
            <main>
                <div class="drawer lg:drawer-open">
                    <input id="drawer" type="checkbox" class="drawer-toggle" />
                    <div class="drawer-content">
                      <!-- Page content here -->
                        {{ $slot }}
                    </div> 
                    <div class="drawer-side">
                      <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                      <livewire:layout.sidebar/>
                    </div>
                  </div>
            </main>
        </div>
    </body>
</html>
