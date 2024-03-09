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

        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 1], 
            ['permission_id' => 2, 'role_id' => 1],
            ['permission_id' => 3, 'role_id' => 1],
            ['permission_id' => 4, 'role_id' => 1],
        ]);

        // Attach forms to superadmin role
        DB::table('form_role')->insert([
            ['form_id' => 1, 'role_id' => 1], 
            ['form_id' => 2, 'role_id' => 1],
        ]);

        // // Attach superadmin role to admin user
        DB::table('role_user')->insert([
            ['role_id' => 1, 'user_id' => 1], 
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('permission_role')->truncate();
        DB::table('form_role')->truncate();
        DB::table('role_user')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();

        Schema::enableForeignKeyConstraints();
    }
};
