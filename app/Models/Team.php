<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'leader_id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function hasMaxMembers(): bool
    {
        // Adjust the maximum number as needed
        return false;
    }
}
