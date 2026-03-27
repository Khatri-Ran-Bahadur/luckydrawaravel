@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Special Users Management</h1>
            <p class="text-gray-600">Manage users who can display wallet information for topups</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                <i class="fas fa-users mr-2"></i>Manage All Users
            </a>
            <a href="{{ url('admin.dashboard') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wallet text-green-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Users with Wallets</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['users_with_wallets']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-star text-purple-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Wallets</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['active_wallets']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Special Users</h3>
            <p class="text-sm text-gray-600 mt-1">Users who can display wallet information for topups</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Wallet Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Wallet Details
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Wallet Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Account Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Balance
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(!empty($users) && count($users))
                    @foreach($users as $user)
                    @php
                    $user = is_array($user) ? (object) $user : $user;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $user->full_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        @{{ $user->username }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->wallet_type && $user->wallet_type !== 'Pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($user->wallet_type) }}
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pending Setup
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if(
                                $user->wallet_name && $user->wallet_name !== 'Pending' &&
                                $user->wallet_number && $user->wallet_number !== 'Pending'
                                )
                                <div><strong>Name:</strong> {{ $user->wallet_name }}</div>
                                <div><strong>Number:</strong> {{ $user->wallet_number }}</div>
                                @if($user->wallet_type === 'bank' && !empty($user->bank_name))
                                <div><strong>Bank:</strong> {{ $user->bank_name }}</div>
                                @endif
                                @else
                                <div class="text-yellow-600">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Wallet details pending setup
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    User needs to complete wallet profile
                                </div>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(
                            $user->wallet_active &&
                            $user->wallet_name && $user->wallet_name !== 'Pending' &&
                            $user->wallet_number && $user->wallet_number !== 'Pending'
                            )
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>Active
                            </span>
                            @elseif($user->wallet_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>Pending Setup
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times mr-1"></i>Inactive
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->status === 'active')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>Active
                            </span>
                            @elseif($user->status === 'suspended')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-ban mr-1"></i>Suspended
                            </span>
                            @elseif($user->status === 'inactive')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-pause mr-1"></i>Inactive
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-question mr-1"></i>Unknown
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                Rs. {{ number_format((float) ($user->balance ?? 0), 2) }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ url('admin/edit-special-user/' . $user->id) }}"
                                class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>

                            <button
                                onclick="openPasswordResetModal({{ $user->id }}, @js($user->username), @js($user->full_name))"
                                class="text-yellow-600 hover:text-yellow-900 mr-3"
                                title="Reset Password">
                                <i class="fas fa-key mr-1"></i>Reset Password
                            </button>

                            <a href="{{ url('admin/users/view/' . $user->id) }}"
                                class="text-green-600 hover:text-green-900">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <i class="fas fa-wallet text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium text-gray-900 mb-2">No Special Users Found</p>
                                <p class="text-gray-600">No users have been designated as special users yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
            <div class="text-sm text-blue-800">
                <p class="font-medium mb-2">How Special Users Work:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Special users are regular users who can display their wallet information for topups</li>
                    <li>When made special, users get basic wallet setup and can complete their profile</li>
                    <li>Only special users with complete wallet information appear on the topup page</li>
                    <li>Users with "Pending Setup" status need to complete their wallet profile</li>
                    <li>You can edit wallet details and activate/deactivate special users as needed</li>
                </ul>
            </div>
        </div>
    </div>
</div>

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
                <p class="text-sm text-gray-600">Reset password for:</p>
                <p class="font-semibold text-gray-900" id="resetUserInfo"></p>
            </div>

            <form id="passwordResetForm">
                @csrf
                <input type="hidden" id="resetUserId" name="user_id">

                <div class="mb-4">
                    <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <div class="relative">
                        <input type="password" id="newPassword" name="new_password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter new password" required minlength="6">
                        <button type="button" onclick="togglePasswordVisibility('newPassword')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="newPasswordToggle"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <div class="relative">
                        <input type="password" id="confirmPassword" name="confirm_password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Confirm new password" required minlength="6">
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

    document.getElementById('passwordResetForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (newPassword !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }

        if (newPassword.length < 6) {
            alert('Password must be at least 6 characters long!');
            return;
        }

        const formData = new FormData(this);

        fetch("{{ route('admin.users.changePassword') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Password reset successfully!');
                    closePasswordResetModal();
                } else {
                    alert('Error: ' + (data.message || 'Failed to reset password'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while resetting the password');
            });
    });

    document.getElementById('passwordResetModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePasswordResetModal();
        }
    });
</script>
@endpush