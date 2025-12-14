<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Refferal;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $referral_code = $data['referral_code'] ?? null;
        if (isset($referral_code) && !empty($referral_code)) {
            $referrer = User::where('referral_code', $data['referral_code'])->first();
            if ($referrer) {
                $data['referred_by'] = $referrer->id;
            }
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'phone' => $data['phone'] ?? null,
            'referral_code' => $data['referral_code'] ?? null,
            'referred_by' => $data['referred_by'] ?? null,
            'wallet_id' => (new User())->generateWalletId(),
        ]);

        //if referral code we need to give bonus to referrer and referee
        if (isset($data['referred_by'])) {
            //give bonus logic here
            $this->processRefferalBonus($referrer->id, $user->id, $referral_code);
        }

        return $user;
    }

    protected function processRefferalBonus($referrer_id, $referee_id, $referral_code)
    {
        try {
            $bonus_amount = 10.00; // Example bonus amount
            $r = new Refferal();
            $r->createReferral($referrer_id, $referee_id, $referral_code, $bonus_amount);
        } catch (\Exception $e) {
            //throw $th;
            Log::error("Error processing referral bonus: " . $e->getMessage());
        }
    }
}
