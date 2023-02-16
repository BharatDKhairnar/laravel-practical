<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessMultiTenant;
use App\Mail\sendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;


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
            'password'               =>  ['required','max:16', Password::min(8)->mixedCase()->symbols()],
            'company_website'        => 'required|url',
            'company_licence_number' => 'required|max:50',                                                                             
            'company_address'        => 'required|max:500',
        ]);

        try {

            // $mailData = [
            //     'title' => "Email Verification",
            //     "bodyMessage" => "Please activate your profile by clicking over the below url."
            // ];
            // Mail::to($request->email)->send(new sendMail($mailData)); // Send the email

            dispatch(new ProcessMultiTenant($request->all()));  // Dispatch the job for new specific database.

            return redirect()->route('login')->with('success','Company Registered Successfully. Here you can login.');
        
        } catch (\Throwable $th) {

            Log::info("Error: ".$th->getMessage());

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

}
