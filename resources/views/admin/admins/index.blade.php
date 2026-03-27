@extends('admin.layouts.app')
@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Admin Management</h2>
                <p class="text-gray-600 mt-1">Manage all admin accounts in the system</p>
            </div>
            <a href="{{route('admin.admins.create')}}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Add New Admin
            </a>
        </div>
    </div>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative success-msg"  role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative failed-msg" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Admins Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
               <i class="fas fa-user text-green-600 text-lg"></i> All Admins
            </h2>
        </div>
        @if($admins->count() > 0)
         <div class="overflow-x-auto">
              <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($admins as $admin)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center overflow-hidden">
                                            <img src="{{asset('storage/' . $admin->profile_image)}}" onerror="this.onerror=null;this.src='{{asset('images/default-avatar.png')}}';" alt="Admin Profile Image" class="w-full h-full object-cover rounded-xl">
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{$admin->name}}</div>
                                            <div class="text-sm text-gray-500">@<span>{{ $admin->username }}</span></div>
                                        </div>
                                    </div>
                                </td>
                                  <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <div class="font-semibold text-green-600">{{ $admin->email }}</div>
                                        <div class="text-gray-500">Phone: {{ $admin->phone }}</div>
                                    </div>
                                </td>

                                  <td class="px-6 py-4">
                                   @if($admin->status =='active')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                            Active
                                        </span>
                                    @else ($admin->status === 'inactive')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1.5"></span>
                                            Inactive
                                        </span>
                                  
                                    @endif
                                </td>


                                 <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                       {{ date('M j, Y', strtotime($admin->created_at)) }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ date('h:i A', strtotime($admin->created_at)) }}
                                    </div>
                                </td>   


                              

                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                       
                                            <a href="{{route('admin.admins.edit',$admin->id)}}"
                                                class="text-blue-600 hover:text-blue-900 transition-colors"
                                                title="Edit">
                                                <i class="fas fa-edit text-lg"></i>
                                            </a>
                                            <button onclick="openPasswordResetModal({{ $admin->id }}, '{{ $admin->username }}', '{{ $admin->name }}')"
                                            class="text-yellow-600 hover:text-yellow-900" title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </button>


                                            <!-- destroy method are DELETE not get method -->
                                             @if(Auth::user()->id != $admin->id)
                                            <form action="{{route('admin.admins.destroy',$admin->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors"
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this admin?')">
                                                    <i class="fas fa-trash text-lg"></i>
                                                </button>
                                            </form>
                                            @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
               
                <!-- for pagination -->
                 <div class="p-6 border-t border-gray-200">
                    {{ $admins->links('vendor.pagination.tailwind') }}
                </div>
        </div>
        @else
            <div class="p-8 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-money-bill-wave text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Admins Yet</h3>
                <p class="text-gray-600 mb-6">Start by creating your first admin</p>
                <a href="{{route('admin.admins.create')}}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Create First Admin
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Password Reset Modal -->
<div id="passwordResetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Reset Admin Password</h3>
                <button onclick="closePasswordResetModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-600">Reset password for admin:</p>
                <p class="font-semibold text-gray-900" id="resetUserInfo"></p>
            </div>

            <form id="passwordResetForm">
                <input type="hidden" id="resetUserId" name="user_id">
                @csrf
                <div class="mb-4">
                    <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <div class="relative">
                        <input type="password" id="newPassword" name="new_password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter new password" required minlength="8">
                        <button type="button" onclick="togglePasswordVisibility('newPassword')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="newPasswordToggle"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <div class="relative">
                        <input type="password" id="confirmPassword" name="new_password_confirmation"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Confirm new password" required minlength="8">
                        <button type="button" onclick="togglePasswordVisibility('confirmPassword')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="confirmPasswordToggle"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closePasswordResetModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
  <script>
    function openPasswordResetModal(userId, username, fullName) {
        document.getElementById('resetUserId').value = userId;
        document.getElementById('resetUserInfo').textContent = fullName + ' (@' + username + ')';
        document.getElementById('passwordResetModal').classList.remove('hidden');
        document.getElementById('newPassword').focus();
    }

    function closePasswordResetModal() {
        document.getElementById('passwordResetModal').classList.add('hidden');
        document.getElementById('passwordResetForm').reset();
    }

    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const toggle = document.getElementById(inputId + 'Toggle');

        if (input.type === 'password') {
            input.type = 'text';
            toggle.classList.remove('fa-eye');
            toggle.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            toggle.classList.remove('fa-eye-slash');
            toggle.classList.add('fa-eye');
        }
    }

    $(document).on('submit', '#passwordResetForm', function(e) {
        e.preventDefault();

        const newPassword = $('#newPassword').val();
        const confirmPassword = $('#confirmPassword').val();

        if (newPassword !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }

        if (newPassword.length < 8) {
            alert('Password must be at least 8 characters long!');
            return;
        }


        $.ajax({
            url: "{{route('admin.admins.reset-password')}}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    closePasswordResetModal();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    });
</script>

@endpush