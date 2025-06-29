<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $firstName = $this->ask('First Name');
        $lastName = $this->ask('Last Name');
        $email = $this->ask('Email');
        $phone = $this->ask('Phone');
        $address = $this->ask('Adress');
        $password = $this->secret('Password');

        // Confirmation
        if (!$this->confirm('Create this admin with this infos?')) {
            $this->warn('Creattion cancelled.');
            return;
        }

        try {
            $admin = Admin::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);

            $this->info("✅ Admin {$admin->email} created succesfully.");
        } catch (\Exception $e) {
            $this->error('❌ Error : ' . $e->getMessage());
        }
    }
}
