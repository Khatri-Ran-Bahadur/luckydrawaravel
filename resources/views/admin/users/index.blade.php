@extends('admin.layouts.app')
@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">User Management</h2>
                <p class="text-gray-600 mt-1">Manage all user accounts in the system</p>
            </div>
        </div>
    </div>
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative success-msg" role="alert">
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
                <i class="fas fa-user text-green-600 text-lg"></i> All Users
            </h2>
        </div>
        @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Special User</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center overflow-hidden">
                                    <img src="{{asset('storage/' . $user->profile_image)}}" onerror="this.onerror=null;this.src='{{asset('images/default-avatar.png')}}';" alt="Admin Profile Image" class="w-full h-full object-cover rounded-xl">
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{$user->name}}</div>
                                    <div class="text-sm text-gray-500">@<span>{{ $user->username }}</span></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <div class="font-semibold text-green-600">{{ $user->email }}</div>
                                <div class="text-gray-500">Phone: {{ $user->phone }}</div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @if($user->status =='active')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                Active
                            </span>
                            @else ($user->status === 'inactive')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1.5"></span>
                                Inactive
                            </span>

                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($user->is_special_user)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1.5"></span>
                                Yes
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span>
                                No
                            </span>
                            @endif


                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ date('M j, Y', strtotime($user->created_at)) }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ date('h:i A', strtotime($user->created_at)) }}
                            </div>
                        </td>




                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">

                                <a href="{{route('admin.users.show',$user->id)}}"
                                    class="text-blue-600 hover:text-blue-900 transition-colors"
                                    title="View Details">
                                    <i class="fas fa-eye text-lg"></i>
                                </a>

                                <a href="{{route('admin.users.toggleSpecialUser',$user->id)}}"
                                    class="text-blue-600 hover:text-blue-900 transition-colors"
                                    title="Toggle Special User">
                                    @if($user->is_special_user)
                                    <i class="fas fa-user-minus text-lg"></i>
                                    @else
                                    <i class="fas fa-user-plus text-lg"></i>
                                    @endif
                                </a>

                                <button onclick="openPasswordResetModal({{ $user->id }}, '{{ $user->username }}', '{{ $user->name }}')"
                                    class="text-yellow-600 hover:text-yellow-900" title="Reset Password">
                                    <i class="fas fa-key"></i>
                                </button>

                                <!-- destroy method are DELETE not get method -->
                                @if(Auth::user()->id != $user->id)
                                <form action="{{route('admin.users.destroy',$user->id)}}" method="POST">
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
                {{ $users->links('vendor.pagination.tailwind') }}
            </div>
        </div>
        @else
        <div class="p-8 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-money-bill-wave text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Users Yet</h3>
            <p class="text-gray-600">There are no users to display. Start adding users to see them here.</p>
        </div>
        @endif
    </div>
</div>

<!-- Password Reset Modal -->
<div id="passwordResetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Reset User Password</h3>
                <button onclick="closePasswordResetModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-600">Reset password for user:</p>
                <p class="font-semibold text-gray-900" id="resetUserInfo"></p>
            </div>

            <form id="passwordResetForm">
                <input type="hidden" id="resetUserId" name="user_id">
                @csrf
                <div class="mb-4">
                    <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <div class="relative">
                        <input type="password" id="newPassword" name="password"
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
                        <input type="password" id="confirmPassword" name="password_confirmation"
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
            url: "{{route('admin.users.changePassword')}}",
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