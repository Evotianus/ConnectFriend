<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function friendOfMine()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public function friendOfUser()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }
}
