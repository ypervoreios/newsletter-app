<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Newsletter Manager
    </title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>


<body class="bg-gray-100">


<div class="min-h-screen flex">


    <!-- Sidebar -->

    <aside class="w-64 bg-gray-900 text-white">


        <div class="p-5 text-xl font-bold">
            Newsletter Manager
        </div>


        <nav class="mt-5">


            <a href="{{ route('dashboard') }}"
               class="block px-5 py-3 hover:bg-gray-800">
                Dashboard
            </a>


            <a href="{{ route('contacts.index') }}"
               class="block px-5 py-3 hover:bg-gray-800">
                Contacts
            </a>


            <a href="{{ route('campaigns.index') }}"
               class="block px-5 py-3 hover:bg-gray-800">
                Campaigns
            </a>


            @if(Auth::check() && Auth::user()->is_admin)
            <a href="{{ route('users.index') }}"
                   class="block px-5 py-3 hover:bg-gray-800">
                    Users
                </a>

                <a href="{{ route('settings.mail') }}"
                   class="block px-5 py-3 hover:bg-gray-800">
                    Settings
                </a>
            @endif

        </nav>


    </aside>




    <!-- Main -->


    <main class="flex-1">


        <!-- Header -->

        <header class="bg-white shadow p-5 flex justify-between">


            <h1 class="text-xl font-semibold">
                @yield('title')
            </h1>


            <div class="relative">
                <button type="button" id="user-menu-button" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="user-menu" class="absolute right-0 mt-2 hidden w-48 rounded-md border border-gray-200 bg-white shadow-lg">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Edit Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>


        </header>




        <section class="p-6">

            @yield('content')

        </section>


    </main>



</div>


@stack('scripts')
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('user-menu-button');
        const menu = document.getElementById('user-menu');

        if (!button || !menu) return;

        button.addEventListener('click', function (event) {
            event.stopPropagation();
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', function () {
            menu.classList.add('hidden');
        });
    });
</script>
</body>

</html>