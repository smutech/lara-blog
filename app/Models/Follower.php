<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follower_id'
    ];

    // Relation between user_id and users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation between follower_id and users
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
