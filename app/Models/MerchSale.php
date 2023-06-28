<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MerchSale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'name',
        'item',
        'count',
        'price', 
        'currency',
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

    /**
     * Find the top 3 merch items based on number sole
     */
    public static function topThree()
    {
        return self::select('item', DB::raw('count(item) as count'))
            ->where('event_time', '>', Carbon::now()->subDays(30))->groupBy('item')
            ->orderBy('count', 'DESC')->limit(3)->get();
    }
}
