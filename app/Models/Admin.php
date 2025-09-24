<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'bio',
        'profile_image',
        'company_name',
        'company_logo',
        'dark_mode',
        'role',
        'permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
        ];
    }

    /**
     * Check if admin has permission for a specific module
     */
    public function hasPermission($module)
    {
        // Super admin has access to everything
        if ($this->role === 'super_admin') {
            return true;
        }

        // Check if permissions array contains the module
        return in_array($module, $this->permissions ?? []);
    }

    /**
     * Check if admin has any of the given permissions
     */
    public function hasAnyPermission($modules)
    {
        // Super admin has access to everything
        if ($this->role === 'super_admin') {
            return true;
        }

        // Check if any of the modules are in permissions array
        $permissions = $this->permissions ?? [];
        return !empty(array_intersect($modules, $permissions));
    }

    /**
     * Get all accessible modules for the admin
     */
    public function getAccessibleModules()
    {
        if ($this->role === 'super_admin') {
            return [
                'Dashboard',
                'employees',
                'tasks',
                'activities',
                'Employee Card',
                'Assigned Items',
                'reports',
                'attendance',
                'salary-slips',
                'visitors',
                'invited-visitors',
                'stock',
                'performance',
                'salary',
                'settings',
                'logs',
            ];
        }

        return $this->permissions ?? [];
    }
}
