<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:init {--p|password=123456 : The super admin password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init super admin accounts';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->confirm('Are you sure you want to do this?')) {
            return ;
        }

        $role = Role::find(1);
        if (! $role) {
            $role = Role::create([
                'name' => 'Admin',
                'title' => '超管'
            ]);
        }

        $admin = Admin::find(1);
        if (! $admin) {
            $password = $this->option('password') ?: '123456';
            $mobile = 18101333903;
            $admin = Admin::create([
                'name' => '超管',
                'type' => 0,
                'mobile' => $mobile,
                'password' => Hash::make($password),
            ]);

            $this->info("Init account: ${mobile}/${password}");
        }

        $this->info('Successful.');
    }
}
