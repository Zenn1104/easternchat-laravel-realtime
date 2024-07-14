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
        @push('script')
          <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.3.1/howler.min.js"></script>
          <script src="{{ asset('js/echo.js') }}"></script>
        @endpush
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-base-200 dark:bg-gray-900">
            {{-- <livewire:layout.navigation /> --}}
              <div id="notification" class="fixed top-0 right-0 w-full max-w-xs p-4 text-gray-900 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-300 hidden z-10" role="alert">
                <div class="flex items-center mb-3">
                  <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">New Notification</span>
                  <button id="close-notification" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white justify-center items-center flex-shrink-0 text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#notification" aria-label="Close">
                    <span class="sr-only">
                      Close
                    </span>
                    <x-tabler-x class="size-5"/>
                  </button>
                </div>
                <div class="flex items-center">
                  <div class="relative inline-block shrink-0">
                    <div class="avatar placeholder">
                      <div class="bg-neutral-focus text-primary rounded-full w-12 h-12 ring-1 ring-inset ring-primary-700/10">
                        <span>
                            <x-tabler-users-group class="size-5"/>
                        </span>
                      </div>
                    </div>
                    <span class="absolute bottom-0 right-0 inline-flex items-center justify-center w-6 h-6 bg-primary rounded-full">
                      <x-tabler-message-circle-2-filled class="size-3"/>
                      <span class="sr-only">Message Icon</span>
                    </span>
                  </div>
                  <div class="ms-3 text-sm font-normal">
                    <div id="notificationSender" class="text-sm font-semibold text-gray-900 dark:text-white"></div>
                    <div id="notificationMessage" class="text-sm font-normal"></div>
                    <span id="notificationSendAt" class="text-xs font-medium text-primary">{{ now()->diffForHumans() }}</span>
                  </div>
                </div>
              </div>
          
            <!-- Page Content -->
            <main>
                <div class="drawer drawer-open">
                    <input id="my-drawer" type="checkbox" class="drawer-toggle" />
                    <div class="drawer-content">
                      <!-- Page content here -->
                        {{ $slot }}
                        @livewire('action.create-group')
                        @livewire('action.edit-group')
                        @livewire('action.add-member')
                    </div> 
                    <div class="drawer-side">
                      <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay">
                      </label>
                      <livewire:layout.sidebar/>
                    </div>
                  </div>
            </main>
        </div>    
    </body>
</html>
