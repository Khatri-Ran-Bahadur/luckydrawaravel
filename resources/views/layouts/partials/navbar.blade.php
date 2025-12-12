<nav class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex item-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="shrink-0 flex items-center group">
                    <div class="relative">
                        <div class="bg-white/10 backdrop-blur-md p-3 rounded-2xl mr-4 group-hover:scale-110 transition-all duration-300 shadow-lg group-hover:shadow-xl border border-white/20">

                            <i class="fas fa-dice text-2xl text-white animate-bounce-slow"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full animate-pluse-slow"></div>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-white">LuckyDraw</span>
                        <p class="text-xs tect-white/80 -mt-1 font-medium">win . Play . Prosper</p>
                    </div>
                </a>
            </div>
            <div class="hidden lg:flex items-center space-x-1">
                <a href="" class="text-white/90 hover:text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:bg-white/10 bg-white/20"><i class="fas fa-home mr-2"></i> {{__("Home")}}</a>
                <a href=""  class="text-white/90 hover:text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:bg-white/10 "><i class="fas fa-dollor-sign mr-2"></i> Cash Draws</a>
                <a href="" class="text-white/90 hover:text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 over:bg-white/10 "><i class="fas fa-gift mr-2"></i> Product Draws</a>
                <a href="" class="text-white/90 hover:text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 over:bg-white/10 "><i class="fas fa-trophy mr-2"></i> Winners</a>
                <a href="" class="text-white/90 hover:text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 over:bg-white/10 "><i class="fas fa-question mr-2"></i> FAQs</a>
                <a href="" class="text-white/90 hover:text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 over:bg-white/10 "><i class="fas fa-envelope mr-2"></i> Contact</a>
            </div>

            <div class="hidden lg:flex items-center space-x-4">

            <!-- User Menu -->
             @auth
                <div class="relative ml-3">
                    <div>
                        <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user Menu</span>
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                U
                            </div>

                            <span class="ml-2 text-gray-700 font-medium hideen md:block">Ran</span>
                            <i class="fas fa-chevron-down mt-1 text-gray-400"></i>
                        </button>
                    </div>

                    <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" id="user-menu"> 
                        <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 " role="menuitem" tabindex="-1">
                            <i class="fas fa-techometer-alt mr-2"></i>
                            Dashboard
                        </a>
                        <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 " role="menuitem" tabindex="-1">
                            <i class="fas fa-user-circle mr-2"></i>
                            Profile
                        </a>
                        <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 " role="menuitem" tabindex="-1">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            My Winnings
                        </a>
                        <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 " role="menuitem" tabindex="-1">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            My Wallet
                        </a>
                        <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 " role="menuitem" tabindex="-1">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Sign Out 
                        </a>
                    </div>
                </div>
                @else
                <!-- if not authenticated -->
                <a href="{{route('login')}}" class="text-white/90 hover:text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:bg-white/10"> {{__("Login")}}</a>

                <a href="{{route('register')}}"  class="bg-white/10 backdrop-blur-md text-white hover:bg:white/20  px-6 py-2 rounded-xl text-sm font-medium transitionall duration-300 border border-white/20">Get Started</a>
                @endauth

            </div>

            <button class="lg:hidden p-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 transition-colors duration-200 " onclick="toggleMobileMenu()">
                <i class="fas fa-bars text-xl"></i>
            </button>


        </div>
    </div>

    <div id="mobileMenu" class="lg:hidden mobile-menu max-h-0 overflow-hidden">
        <div class="px-4 pt-2 pb-4 space-y-2 bg-white/5 backdrop-blue-md  border-t vorder-white/10">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-white font-medium">Menu</h3>
                <button onclick="toggleMobileMenu()" class="p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <a href="{{route('home')}}"  class="text-white/90 hover:text-white px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 hover:bg-white/10 flex items-center">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-3 border border-white/20">
                    <i class="fas fa-home text-white" ></i>
                </div>
                Home
            </a>
            <a href="{{route('home')}}"  class="text-white/90 hover:text-white px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 hover:bg-white/10 flex items-center">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-3 border border-white/20">
                    <i class="fas fa-tachometer-alt text-white" ></i>
                </div>
                Dashboard
            </a>
            <a href="{{route('home')}}"  class="text-white/90 hover:text-white px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 hover:bg-white/10 flex items-center">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-3 border border-white/20">
                    <i class="fas fa-trophy text-white" ></i>
                </div>
                My Winnings
            </a>

            <a href="{{route('home')}}"  class="text-white/90 hover:text-white px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 hover:bg-white/10 flex items-center">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-3 border border-white/20">
                    <i class="fas fa-wallet text-white" ></i>
                </div>
                My Wallet
            </a>

            <a href="{{route('home')}}"  class="text-white/90 hover:text-white px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 hover:bg-white/10 flex items-center">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-3 border border-white/20">
                    <i class="fas fa-user-circle text-white" ></i>
                </div>
                My Profile
            </a>

            <a href="{{route('home')}}"  class="text-white/90 hover:text-white px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 hover:bg-white/10 flex items-center">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-3 border border-white/20">
                    <i class="fas fa-home text-white" ></i>
                </div>
                Sign Out
            </a>


        </div>

    </div>
</nav>