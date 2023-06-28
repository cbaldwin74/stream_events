<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\MerchSale;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    private const STREAM_QUERY = <<<EOT
COALESCE(donations.id, followers.id, merch_sales.id, subscribers.id) id,
    COALESCE(donations.name, followers.name, merch_sales.name, subscribers.name) 'name',
	COALESCE(donations.read, followers.read, merch_sales.read, subscribers.read) 'read',
	COALESCE(donations.amount, NULL, merch_sales.price, NULL) amount,
	COALESCE(donations.currency, NULL, merch_sales.currency, NULL) currency,
	COALESCE(NULL, NULL, merch_sales.item, NULL) item,
	COALESCE(NULL, NULL, merch_sales.count, NULL) count,
	COALESCE(donations.message, NULL, NULL, NULL) message,
	COALESCE(NULL, NULL, NULL, subscribers.tier) tier,
  	COALESCE(donations.event_time, followers.event_time, merch_sales.event_time, subscribers.event_time) event_time
from (
	SELECT 'donations' as source, user_id from donations
	UNION
	SELECT 'followers' as source, user_id from followers
	UNION
	SELECT 'merch_sales' as source, user_id from merch_sales
	UNION
	SELECT 'subscribers' as source, user_id from subscribers
) ad
LEFT JOIN donations on ad.user_id = donations.user_id AND ad.source = 'donations'
LEFT JOIN followers on ad.user_id = followers.user_id AND ad.source = 'followers'
LEFT JOIN merch_sales on ad.user_id = merch_sales.user_id AND ad.source = 'merch_sales'
LEFT JOIN subscribers on ad.user_id = subscribers.user_id AND ad.source = 'subscribers'
WHERE ad.user_id = ?
EOT;
//order by event_time DESC limit 100;
    private const SUB_REVENUE= [500, 1000, 1500];

    /**
     * Return the number of followers gained by the given user in
     * the past 30 days
     */
    public function stream()
    {
        $id = Auth::id();
        return DB::query()->selectRaw(self::STREAM_QUERY, [$id])->orderBy('event_time')->cursorPaginate(100);
    }

    /**
     * Return the total revenue for the last 30 days
     */
    public function totalRevenue()
    {
        $subscribers = Subscriber::select('tier', DB::raw('count(*) as count'))->where('event_time', '>', Carbon::now()->subDays(30))->groupBy('tier')->orderBy('tier')->get();
        // Total up the subscriber revenue
        // Tier1: 5$ , Tier2: 10$, Tier3: 15$
        $sub_total = 0;
        foreach ($subscribers as $tier) {
            $sub_total += $tier['count'] * self::SUB_REVENUE[$tier['tier'] - 1];
        }

        $merch = MerchSale::select()->where('event_time', '>', Carbon::now()->subDays(30))->sum('price');
        $donations = Donation::select()->where('event_time', '>', Carbon::now()->subDays(30))->sum('amount');

        return $sub_total + $merch + $donations;
    }
}
