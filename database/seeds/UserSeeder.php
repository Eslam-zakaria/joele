<?php

use App\Constants\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Permission\Repositories\PermissionsRepository;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'jumppeak',
            'username' => 'admin',
            'email' => 'tech@jumppeak.net',
            'password' =>'password',
            'email_verified_at' => now()
        ]);

        $permissions = app(PermissionsRepository::class)->list()->pluck('id')->toArray();

        $user->syncPermissions($permissions);

        #factory(User::class, 100)->create();
    }
}
