<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('group')->nullable();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['role_id', 'user_id']);
        });

        // Seed default roles
        $roles = [
            ['name' => 'Administrator', 'slug' => 'admin', 'description' => 'Full system access'],
            ['name' => 'Project Manager', 'slug' => 'project_manager', 'description' => 'Manage projects, tasks, and time entries'],
            ['name' => 'Developer', 'slug' => 'developer', 'description' => 'View projects, log time, manage tasks'],
            ['name' => 'Accountant', 'slug' => 'accountant', 'description' => 'Manage invoices, expenses, and reports'],
            ['name' => 'Support Agent', 'slug' => 'support', 'description' => 'Manage tickets and client communication'],
            ['name' => 'Client', 'slug' => 'client', 'description' => 'Access client portal only'],
        ];
        foreach ($roles as $role) {
            \DB::table('roles')->insert(array_merge($role, ['created_at' => now(), 'updated_at' => now()]));
        }

        // Seed default permissions
        $permissions = [
            // Projects
            ['name' => 'View Projects', 'slug' => 'projects.view', 'group' => 'Projects'],
            ['name' => 'Create Projects', 'slug' => 'projects.create', 'group' => 'Projects'],
            ['name' => 'Edit Projects', 'slug' => 'projects.edit', 'group' => 'Projects'],
            ['name' => 'Delete Projects', 'slug' => 'projects.delete', 'group' => 'Projects'],
            // Tasks
            ['name' => 'View Tasks', 'slug' => 'tasks.view', 'group' => 'Tasks'],
            ['name' => 'Create Tasks', 'slug' => 'tasks.create', 'group' => 'Tasks'],
            ['name' => 'Edit Tasks', 'slug' => 'tasks.edit', 'group' => 'Tasks'],
            // Invoices
            ['name' => 'View Invoices', 'slug' => 'invoices.view', 'group' => 'Invoices'],
            ['name' => 'Create Invoices', 'slug' => 'invoices.create', 'group' => 'Invoices'],
            ['name' => 'Edit Invoices', 'slug' => 'invoices.edit', 'group' => 'Invoices'],
            // Tickets
            ['name' => 'View Tickets', 'slug' => 'tickets.view', 'group' => 'Tickets'],
            ['name' => 'Manage Tickets', 'slug' => 'tickets.manage', 'group' => 'Tickets'],
            // Clients
            ['name' => 'View Clients', 'slug' => 'clients.view', 'group' => 'Clients'],
            ['name' => 'Manage Clients', 'slug' => 'clients.manage', 'group' => 'Clients'],
            // Expenses
            ['name' => 'View Expenses', 'slug' => 'expenses.view', 'group' => 'Expenses'],
            ['name' => 'Manage Expenses', 'slug' => 'expenses.manage', 'group' => 'Expenses'],
            // Content
            ['name' => 'Manage Blog', 'slug' => 'blog.manage', 'group' => 'Content'],
            ['name' => 'Manage FAQ', 'slug' => 'faq.manage', 'group' => 'Content'],
            // Users
            ['name' => 'Manage Users', 'slug' => 'users.manage', 'group' => 'Users'],
            // Reports
            ['name' => 'View Reports', 'slug' => 'reports.view', 'group' => 'Reports'],
            // Settings
            ['name' => 'Manage Settings', 'slug' => 'settings.manage', 'group' => 'Settings'],
        ];
        foreach ($permissions as $perm) {
            \DB::table('permissions')->insert(array_merge($perm, ['created_at' => now(), 'updated_at' => now()]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
