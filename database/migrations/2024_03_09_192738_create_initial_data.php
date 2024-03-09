<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Form;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Insert forms
        DB::table('forms')->insertOrIgnore([
            ['name' => 'Roles', 'route' => 'roles'],
            ['name' => 'Articulo', 'route' => 'articles'],
        ]);

        //Insert permissions
        DB::table('permissions')->insert([
            ['name' => 'create'],
            ['name' => 'read'],
            ['name' => 'update'],
            ['name' => 'delete'],
        ]);

        // Insert admin user with superadmin role
        $admin = User::create([
            'fullname' => 'Admin',
            'nickname' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);

        // Insert Role
        $superadmin = Role::create([
            'name' => 'Superadmin',
            'description' => 'Super administrator role',
            'tag' => 'superadmin',
            'user_create_id' => $admin->id
        ]);

        //Attach Permissions to superadmin role
        $permissions = Permission::all();
        $superadmin->permissions()->attach($permissions);

        // Attach forms to superadmin role
        $forms = Form::whereIn('route', ['roles', 'articles'])->get();
        $superadmin->forms()->attach($forms);

        // Attach superadmin role to admin user
        $admin->roles()->attach($superadmin);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('permission_role')->truncate();
        DB::table('form_role')->truncate();
        DB::table('role_user')->truncate();

        DB::table('permissions')->truncate();
        DB::table('forms')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
    }
};
