<?php

use App\User;
use Illuminate\Database\Seeder;

// Laravel seeders intentionally have no namespace
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * Seeder for Users, creates a single admin user.
 *
 * @package User
 */
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin           = new User();
        $admin->name     = 'Admin';
        $admin->email    = 'admin@example.com';
        $admin->password = password_hash('password', PASSWORD_DEFAULT);
        $admin->save();
    }
}
