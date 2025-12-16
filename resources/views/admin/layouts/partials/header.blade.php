 <header class="sticky top-0 z-30 flex h-20 shrink-0 items-center header-glass px-4 shadow-sm sm:px-6 lg:px-8">
     <!-- Mobile menu button -->
     <button id="mobileMenuBtn" type="button" class="p-2.5 text-gray-700 lg:hidden glass rounded-xl hover:bg-white/50 transition-all duration-200" onclick="toggleSidebar()">
         <i class="fas fa-bars h-6 w-6"></i>
     </button>

     <!-- Page Title & Breadcrumb -->
     <div class="flex flex-1 items-center">
         <div class="ml-4 lg:ml-0">
             <h1 class="text-2xl font-semibold text-gray-900">
                 Dashboard
             </h1>
             <p class="mt-1 text-sm text-gray-500">
                 Welcome back! Here\'s what\'s happening with your system today.
             </p>
         </div>
     </div>

     <!-- Header Right Side -->
     <div class="flex items-center gap-x-3 ml-4">
         <!-- Search -->
         <div class="relative hidden lg:block">
             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                 <i class="fas fa-search h-5 w-5 text-gray-400"></i>
             </div>
             <input type="text" placeholder="Search anything..." class="input-glass pl-10 text-sm w-72">
         </div>

         <!-- Notifications -->


         <!-- Profile -->
         <div class="flex items-center gap-x-3 p-2 rounded-xl bg-blue-600/90 hover:bg-blue-600 transition-all duration-200 group backdrop-blur-lg cursor-pointer" onclick="showUserMenu()">
             <div class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center shadow-md ring-2 ring-white/30">
                 <span class="text-white font-semibold text-sm">
                     Admin
                 </span>
             </div>
             <div class="hidden lg:block">
                 <span class="text-sm font-semibold text-white group-hover:text-white transition-colors">
                     Admin User
                 </span>
                 <p class="text-xs text-white/80 group-hover:text-white transition-colors">Administrator</p>
             </div>
             <i class="fas fa-chevron-down text-white/80 text-xs"></i>
         </div>

         <!-- Logout -->
         <a href="#" onclick="logout()" class="flex items-center gap-x-2 px-4 py-3 text-sm font-medium text-gray-700 hover:text-red-600 rounded-xl glass hover:bg-red-50/50 transition-all duration-200 group">
             <i class="fas fa-sign-out-alt h-5 w-5 group-hover:scale-110 transition-transform duration-200"></i>
             <span class="hidden sm:block">Logout</span>
         </a>

         <form action="{{route('logout')}}" method="POST" id="logoutFormHeader">@csrf</form>
     </div>
 </header>