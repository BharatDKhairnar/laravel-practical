<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(isset(Auth::user()->database_name) && !empty(Auth::user()->database_name)){
                $dbName = Auth::user()->database_name;
                $dbName = Crypt::decryptString($dbName);
                config(['database.connections.tenant.database' => $dbName]); // Set the database name
                DB::purge('tenant');
                DB::reconnect('tenant');
            } else {
                config(['database.connections.tenant.database' => $_ENV['DB_DATABASE']]); // Set the database name
                DB::purge('mysql');
                DB::reconnect('mysql');
            }
            return $next($request);
        });

        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * User Profile
     * @param Nill
     * @return View Profile
     */
    public function getProfile()
    {
        $user = DB::connection('tenant')->table('users')
                                        ->where('email',Auth::user()->email)
                                        ->first();
        return view('profile',['user' => $user]);
    }

    /**
     * Update Profile
     * @param $profileData
     * @return Boolean With Success Message
     */
    public function updateProfile(Request $request)
    {
        #Validations
        $request->validate([
            'company_name'    => 'required',
            'company_website'     => 'required',
            'company_licence_number' => 'required',
        ]);

        try {
            DB::beginTransaction();
            unset($request['_token']);
            #Update Profile Data
            $user = DB::connection('tenant')->table('users')
                                        ->where('email',Auth::user()->email)
                                        ->update($request->all());

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Profile Updated Successfully.');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Change Password
     * @param Old Password, New Password, Confirm New Password
     * @return Boolean With Success Message
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        try {
            DB::beginTransaction();

            #Update Password
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
            
            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Password Changed Successfully.');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}
