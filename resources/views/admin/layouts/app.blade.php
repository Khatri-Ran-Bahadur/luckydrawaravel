<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/admin.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
</head>

<body class="min-h-screen bg-white relative transition-colors duration-200">
    <!-- Background decorations -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-full blur-3xl opacity-30 floating-animation"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-gradient-to-r from-purple-50 to-pink-50 rounded-full blur-3xl opacity-30 floating-animation" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-full blur-3xl opacity-30 floating-animation" style="animation-delay: 4s;"></div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 z-30 bg-black/20 backdrop-blur-sm lg:hidden hidden" onclick="toggleSidebar()"></div>

    <!-- siderbar -->
    @include('admin.layouts.partials.sidebar')

    <!-- Main Content -->
    <div class="lg:pl-64 relative main-content-mobile">
        @include('admin.layouts.partials.header')
        <main class="py-6 transition-colors duration-200 bg-white min-h-screen">
            <div class="mx-auto max-w-7xl px-3 sm:px-4 lg:px-6">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- User Menu Modal (hidden by default) -->
    <div id="userMenu" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black/20 backdrop-blur-sm" onclick="hideUserMenu()"></div>
        <div class="fixed bottom-4 left-4 lg:left-68 w-64 bg-white rounded-2xl shadow-2xl border border-gray-200/50 overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 gradient-primary rounded-full flex items-center justify-center">
                        <span class="text-white font-bold">
                            Admin
                        </span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Admin User</p>
                        <p class="text-sm text-gray-500">Administrator</p>
                    </div>
                </div>
            </div>
            <div class="p-2">
                <a href="" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-user-circle mr-3"></i>
                    My Profile
                </a>
                <hr class="my-2">
                <a href="" class="flex items-center px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Sign Out
                </a>
            </div>
        </div>
    </div>

    <script>
        // Sidebar functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('hidden');
        }

        // User menu functionality
        function showUserMenu() {
            document.getElementById('userMenu').classList.remove('hidden');
        }

        function hideUserMenu() {
            document.getElementById('userMenu').classList.add('hidden');
        }

        // Close sidebar when clicking outside on mobile
        document.getElementById('sidebarOverlay').addEventListener('click', toggleSidebar);

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024) {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.add('hidden');
            }
        });

        // Enhanced keyboard navigation
        document.addEventListener('keydown', function(e) {
            // Escape to close menus
            if (e.key === 'Escape') {
                hideUserMenu();
                if (window.innerWidth <= 1024) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebarOverlay');
                    sidebar.classList.remove('open');
                    overlay.classList.add('hidden');
                }
            }

            // Ctrl/Cmd + K for search focus
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('input[placeholder="Search anything..."]');
                if (searchInput) {
                    searchInput.focus();
                }
            }
        });

        // Auto-hide notifications after interaction
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });

        function logout() {
            document.getElementById('logoutFormHeader').submit();
        }

        setTimeout(function() {
            document.querySelector('.success-msg').classList.add('hidden');
        }, 5000);

        setTimeout(function() {
            document.querySelector('.failed-msg').classList.add('hidden');
        }, 5000);
    </script>
</body>

</html>