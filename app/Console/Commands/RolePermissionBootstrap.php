<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class RolePermissionBootstrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cogent:bootstrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create roles and permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $roles = ['super_admin' => "Super Admin", 'admin' => "Admin", 'user' => "User"];

        $permissions = [
            "create_users" => "Create Users",
            "list_users" => "List Users",
            "show_users" => "Show Users",
            "update_users" => "Update Users",
            "delete_users" => "Delete Users",
        ];


        $this->line('------------- Setting Up Roles:');

        foreach ($roles as $roleName => $roleDescription) {
            $role = Role::updateOrCreate(['name' => $roleName, 'description' => $roleDescription, 'guard_name' => 'web']);
            $this->info("Created " . $role->name . " Role");
        }

        $this->line('------------- Setting Up Permissions:');

        foreach ($permissions as $permissionName => $permissionDescription) {
            $permission = Permission::updateOrCreate([
                'name' => $permissionName,
                'description' => $permissionDescription,
                'guard_name' => 'web'
            ]);

            $this->info("Created " . $permission->name . " Permission");
        }

        $this->info("\n\nCreating Super Admin.\n\n");

        $name =  $this->ask('What is your name ?');
        $email = $this->ask('Provide your email address ?');
        $password = $this->secret('Enter a secure password');
        $passwordConfirmation = $this->secret('Confirm your password');

        while ($password !== $passwordConfirmation) {
            $this->error('Passwords does not match!');

            $password = $this->secret('Enter a secure password');
            $passwordConfirmation = $this->secret('Confirm your password');
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $superAdmin = Role::where('name', 'super_admin')->first();
        $user->assignRole($superAdmin);

        $this->info('Superuser created !');

        $this->info("All permissions are granted to Super Admin");
        $this->line('------------- Application Bootstrapping is Complete: \n');
    }
}
