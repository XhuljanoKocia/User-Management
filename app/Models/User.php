<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * Check if the user has a role
     * @param string $role (The role is a string)
     * @return bool (The method return true or false)
     */
    public function hasAnyRole(string $role) {
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
     * Check if the user has any given role
     * @param array $role (The role is an array of values)
     * @return bool (The method return true or false)
     */
    public function hasAnyRoles(array $role) {
        return null !== $this->roles()->whereIn('name', $role)->first();
    }
}
