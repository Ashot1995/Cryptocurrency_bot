<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\RoleHierarchy;

class UsersAndNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfUsers = 10;
        $numberOfNotes = 100;
        $usersIds = array();
        $statusIds = array();
        $faker = Faker::create();
        /* Create roles */
        $adminRole = Role::create(['name' => 'admin']);
        RoleHierarchy::create([
            'role_id' => $adminRole->id,
            'hierarchy' => 1,
        ]);
        $userRole = Role::create(['name' => 'user']);
        RoleHierarchy::create([
            'role_id' => $userRole->id,
            'hierarchy' => 2,
        ]);
        $guestRole = Role::create(['name' => 'guest']);
        RoleHierarchy::create([
            'role_id' => $guestRole->id,
            'hierarchy' => 3,
        ]);


        /*  insert users   */
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'), // password
            'remember_token' => Str::random(10),
            'menuroles' => 'user,admin'
        ]);
        $user->assignRole('admin');
        $user->assignRole('user');
        $user = User::create([
            'name' => $faker->name(),
            'email' => 'laravel2019@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('111111'), // password
            'remember_token' => Str::random(10),
            'menuroles' => 'user'
        ]);
        $user->assignRole('user');
        for($i = 0; $i<$numberOfUsers; $i++){
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('user'), // password
                'remember_token' => Str::random(10),
                'menuroles' => 'user'
            ]);
            $user->assignRole('user');
            array_push($usersIds, $user->id);
        }
    }
}
