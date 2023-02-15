<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessMultiTenant;
use App\Mail\sendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }


    /**
     * List User 
     * @param Nill
     * @return Array $user
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('companies.index', ['users' => $users]);
    }
    
    /**
     * Create User 
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function create()
    {
        return view('companies.add');
    }

    /**
     * Store User
     * @param Request $request
     * @return View Users
     */
    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'company_name'           => 'required|max:100',
            'email'                  => 'required|max:100|unique:users,email',
            'password'               =>  ['required'],//'max:16', Password::min(8)->mixedCase()->symbols()
            'company_website'        => 'required|url',
            'company_licence_number' => 'required|max:50',                                                                             
            'company_address'        => 'required|max:500',
        ]);

        try {

            $mailData = [
                'title' => "Email Verification",
                "bodyMessage" => "Please activate your profile by clicking over the below url."
            ];

            Mail::to($request->email)->send(new sendMail($mailData)); // Send the email

            dispatch(new ProcessMultiTenant($request->all()));  // Dispatch the job for new specific database.

            return redirect()->route('login')->with('success','Company Registered Successfully. Here you can login.');
        
        } catch (\Throwable $th) {

            Log::info("Error: ".$th->getMessage());

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Update Status Of User
     * @param Integer $status
     * @return List Page With Success
     */
    public function updateStatus($user_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'user_id'   => $user_id,
            'status'    => $status
        ], [
            'user_id'   =>  'required|exists:users,id',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if($validate->fails()){
            return redirect()->route('companies.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            User::whereId($user_id)->update(['status' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('companies.index')->with('success','User Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Edit User
     * @param Integer $user
     * @return Collection $user
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit')->with([
            'roles' => $roles,
            'user'  => $user
        ]);
    }

    /**
     * Update User
     * @param Request $request, User $user
     * @return View Users
     */
    public function update(Request $request, User $user)
    {
        // Validations
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|unique:users,email,'.$user->id.',id',
            'mobile_number' => 'required|numeric|digits:10',
            'role_id'       =>  'required|exists:roles,id',
            'status'       =>  'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {

            // Store Data
            $user_updated = User::whereId($user->id)->update([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'mobile_number' => $request->mobile_number,
                'role_id'       => $request->role_id,
                'status'        => $request->status,
            ]);

            // Delete Any Existing Role
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            
            // Assign Role To User
            $user->assignRole($user->role_id);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('companies.index')->with('success','User Updated Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Delete User
     * @param User $user
     * @return Index Users
     */
    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            // Delete User
            User::whereId($user->id)->delete();

            DB::commit();
            return redirect()->route('companies.index')->with('success', 'User Deleted Successfully!.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function dashboard() {
        dd("yes login");
    }

}
