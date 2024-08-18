<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

 
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function leadingTeams()
    {
        return $this->hasMany(Team::class, 'leader_id');
    }

   
    public function isLeader()
    {
        return $this->leadingTeams()->exists();
    }
}
