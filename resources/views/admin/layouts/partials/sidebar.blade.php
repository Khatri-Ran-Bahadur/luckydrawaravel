<!-- Sidebar -->

@php
$route=Route::current()->getName();
$full_route=$route;
$route=str_replace('.index','',$route);
$route=str_replace('.create','',$route);
$route=str_replace('.edit','',$route);
$route=str_replace('.show','',$route);
$route=str_replace('admin.','',$route);

@endphp


<aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 sidebar-glass lg:translate-x-0 sidebar-mobile sidebar-container">
    <!-- Sidebar header -->
    <div class="flex h-20 items-center px-4 border-b border-gray-200/50 flex-shrink-0">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">L</span>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">LuckDraw</h1>
                <p class="text-xs text-gray-500">Admin Dashboard</p>
            </div>
        </div>
        <!-- Close button for mobile -->
        <button id="closeSidebar" class="ml-auto p-2 rounded-lg glass hover:bg-gray-100/50 transition-all duration-200 lg:hidden" onclick="toggleSidebar()">
            <i class="fas fa-times h-5 w-5 text-gray-600"></i>
        </button>
    </div>

    <!-- Scrollable Navigation Container -->
    <div class="sidebar-scrollable">
        <!-- Navigation -->
        <nav class="px-4 py-4 space-y-2">
            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 py-2">Main Menu</div>

            <!-- Dashboard -->
            <a href="" class="nav-item {{in_array($route,['dashboard'])?'nav-item-active':'nav-item-innactive'}}">
                <i class="fas fa-th-large mr-3 h-5 w-5 flex-shrink-0"></i>
                Dashboard
            </a>

            <!-- Lucky Draw Management -->
            <div class="space-y-1">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 py-2 mt-4">Draw Management</div>

                <a href="{{route('admin.cashdraws.index')}}" class="nav-item {{in_array($route,['cashdraws'])?'nav-item-active':'nav-item-innactive'}}">
                    <i class="fas fa-money-bill-wave mr-3 h-5 w-5 flex-shrink-0"></i>
                    Cash Draws
                </a>

                <a href="{{route('admin.productdraws.index')}}" class="nav-item {{in_array($route,['productdraws'])?'nav-item-active':'nav-item-innactive'}}">
                    <i class="fas fa-gift mr-3 h-5 w-5 flex-shrink-0"></i>
                    Product Draws
                </a>

                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-trophy mr-3"></i>
                    Winners
                </a>

                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-check-circle mr-3"></i>
                    Approve Claims
                </a>
            </div>

            <!-- User Management -->
            <div class="space-y-2">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">User Management</h3>
                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-users mr-3 h-5 w-5 flex-shrink-0"></i>
                    All Users
                </a>
                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-star mr-3 h-5 w-5 flex-shrink-0"></i>
                    Special Users
                </a>
                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-user-shield mr-3 h-5 w-5 flex-shrink-0"></i>
                    Admin Users
                </a>
            </div>

            <!-- Finance Management -->
            <div class="space-y-2">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Finance</h3>
                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-wallet mr-3 h-5 w-5 flex-shrink-0"></i>
                    Top-up Requests
                </a>
                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-money-bill-wave mr-3 h-5 w-5 flex-shrink-0"></i>
                    Withdrawal Requests
                </a>

            </div>

            <!-- System Management -->
            <div class="space-y-2">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">System</h3>
                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-comments mr-3 h-5 w-5 flex-shrink-0"></i>
                    Chat Management
                </a>
                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-envelope mr-3 h-5 w-5 flex-shrink-0"></i>
                    Contact Submissions
                </a>
                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-bell mr-3 h-5 w-5 flex-shrink-0"></i>
                    Notifications
                </a>
                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-user-circle mr-3 h-5 w-5 flex-shrink-0"></i>
                    My Profile
                </a>
                <a href="" class="nav-item nav-item-inactive">
                    <i class="fas fa-wallet mr-3 h-5 w-5 flex-shrink-0"></i>
                    Admin Wallet
                </a>
            </div>

            <!-- Add some padding at the bottom -->
            <div class="h-8"></div>
        </nav>
    </div>

    <!-- Fixed bottom section -->
    <div class="sidebar-fixed-bottom">
        <!-- Settings section -->
        <div class="p-3">
            <a href="" class="nav-item nav-item-inactive">
                <i class="fas fa-cog mr-3 h-5 w-5 flex-shrink-0"></i>
                Settings
            </a>
        </div>

        <!-- User section -->
        <div class="p-3">
            <div class="flex items-center space-x-3 p-2 rounded-xl glass-card hover:bg-gray-50/50 transition-all duration-200 cursor-pointer" onclick="showUserMenu()">
                <div class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                    <span class="text-white font-medium text-sm">
                        Admin
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">
                        Admin User
                    </p>
                    <p class="text-xs text-gray-500 truncate">Administrator</p>
                </div>
                <button class="p-1 rounded-md hover:bg-gray-100 transition-colors">
                    <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                </button>
            </div>
        </div>
    </div>
</aside>