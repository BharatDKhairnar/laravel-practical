<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ProcessMultiTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function start()
    {
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        $db = DB::select($query, [$this->request['company_name']]);
        if (empty($db)) {
            $dbName = 'tenant'.strtolower( Str::replace(" ","",$this->request['company_name']) );
            Schema::createDatabase($dbName);
            Schema::create($dbName.'.users', function (Blueprint $table) {
                $table->id();
                $table->string('company_name');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('company_website');
                $table->string('company_licence_number');
                $table->string('company_address');
                $table->string('country');
                $table->string('state');
                $table->string('city');
                $table->timestamp('emaill_verified_at')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->rememberToken();
                $table->timestamps();
            });

            DB::beginTransaction();
            try {
            
                $user = User::create([
                    'first_name' => $this->request['company_name'],
                    'email' => $this->request['email'],
                    'password' => bcrypt($this->request['password']),
                    'database_name' => $dbName
                ]);

                $user->sendEmailVerificationNotification(); // Email send for verification

                unset($this->request['_token']);
                $this->request['password'] = bcrypt($this->request['password']);
                $this->request['created_at'] = \Carbon\Carbon::now();
                $this->request['updated_at'] = \Carbon\Carbon::now();
                DB::table($dbName.'.users')->insert($this->request); // Store Data

                // Commit the DB
                DB::commit();
                Log::info("Database created successfully");

            } catch (\Throwable $th) {
                // Rollback and return with Error
                DB::rollBack();
                Log::info($th->getMessage());
            }
        } else {
            Log::info('Company name already exists');
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->start();
    }
}
