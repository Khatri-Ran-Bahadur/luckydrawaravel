<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\View\View;
use App\Models\SpecialUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::notAdmin()->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::isUser()->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::isUser()->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function resetPassword(UserUpdateRequest $request)
    {
        $user = User::notAdmin()->findOrFail($request->user_id);
        $user->update([
            'password' =>  Hash::make($request->password),
        ]);
        return response()->json(['message' => 'Password reset successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::isUser()->findOrFail($id);
        // delete image
        if ($user->profile_image) {
            ImageUploader::delete($user->profile_image);
        }
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function toggleSpecialUser($id)
    {

        $user = User::notAdmin()->findOrFail($id);
        $user->is_special_user = !$user->is_special_user;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully');
    }

    public function specialUsers(Request $request): View
    {
        $perPage = $request->per_page ?? 20;

        $users = User::query()
            ->with('wallet')
            ->isSpecialUser()
            ->select('users.*')
            ->selectRaw('COALESCE(wallets.balance, 0) as balance')
            ->leftJoin('wallets', 'users.id', '=', 'wallets.user_id')
            ->latest()
            ->paginate($perPage);

        $stats = [
            'total_users' => User::query()->isSpecialUser()->count(),
            'users_with_wallets' => User::isSpecialUser()->whereHas('wallet')->count(),
            'active_wallets' => User::isSpecialUser()->whereHas('wallet', function ($q) {
                $q->where('status', 'active');
            })
                ->count(),
        ];


        return view('admin.users.special-users', [
            'users' => $users,
            'stats' => $stats
        ]);
    }

    public function specialUsersRequest(Request $request): View|RedirectResponse
    {
        $perPage = $request->per_page ?? 20;
        try {
            $requests = SpecialUserRequest::query()
                ->with('user')
                ->latest()
                ->get();

            $stats = [
                'total_requests' => SpecialUserRequest::count(),
                'pending_requests' => SpecialUserRequest::where('status', 'pending')->count(),
                'approved_requests' => SpecialUserRequest::where('status', 'approved')->count(),
                'rejected_requests' => SpecialUserRequest::where('status', 'rejected')->count(),
            ];


            return view('admin.users.special-users-request', [
                'requests' => $requests,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            //throw $th;
            Log::error($e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', "Error loading special user requests " . $e->getMessage());
        }
    }
}
