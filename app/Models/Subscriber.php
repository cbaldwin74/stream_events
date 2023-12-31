<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'name', 
        'tier',
        'read',
        'event_time',
        'user_id',
    ];

    /**
     * Get the user that was followed
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
