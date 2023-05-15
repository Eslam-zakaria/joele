<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {

            \Spatie\Permission\Models\Permission::where('name','list testimonials')->delete();
            \Spatie\Permission\Models\Permission::where('name','create testimonial')->delete();
            \Spatie\Permission\Models\Permission::where('name','edit testimonial')->delete();
            \Spatie\Permission\Models\Permission::where('name','delete testimonial')->delete();
            $permissions = [

                # Redirections URL permissions.
                [
                    'name' => 'list redirections urls',
                    'display_name' => 'All Redirections URLS',
                    'group_name' => 'redirections url'
                ],
                [
                    'name' => 'create redirections url',
                    'display_name' => 'Add redirections url',
                    'group_name' => 'redirections url'
                ],
                [
                    'name' => 'edit redirections url',
                    'display_name' => 'Edit redirections url',
                    'group_name' => 'redirections url'
                ],
                [
                    'name' => 'delete redirections url',
                    'display_name' => 'Delete redirections url',
                    'group_name' => 'redirections url'
                ],

                 # Frequently Question permissions.
                [
                    'name' => 'list frequently questions',
                    'display_name' => 'All Frequently Questions',
                    'group_name' => 'frequently question'
                ],
                [
                    'name' => 'create frequently question',
                    'display_name' => 'Add frequently question',
                    'group_name' => 'frequently question'
                ],
                [
                    'name' => 'edit frequently question',
                    'display_name' => 'Edit frequently question',
                    'group_name' => 'frequently question'
                ],
                [
                    'name' => 'delete frequently question',
                    'display_name' => 'Delete frequently question',
                    'group_name' => 'frequently question'
                ],
            ];
            
            app()['cache']->forget('spatie.permission.cache');

            foreach ($permissions as $permission){
                \Spatie\Permission\Models\Permission::create($permission);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
        });
    }
}
