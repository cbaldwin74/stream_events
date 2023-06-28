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
    /**
     * TLDR: Overall, the query retrieves relevant data from multiple tables for a given user ID 
     * and combines them into a single result set, handling missing values gracefully using 
     * the `COALESCE` function.
     * 
     * Details:
     * 
     * This SQL query retrieves data from multiple tables (`donations`, `followers`, `merch_sales`, `subscribers`) 
     * based on a given user ID and combines the results into a single result set. 
     * Here's a breakdown of the query:
     * 
     * 1. The `SELECT` statement is used to select the columns that will be included in the result set. 
     *    The `COALESCE` function is used to select the first non-null value from a list of columns. 
     * 2. The `FROM` clause includes a subquery that combines the data from all the tables using the 
     *   `UNION` operator. This subquery assigns a source value to each row indicating which table 
     *    the data originated from.
     * 3. The `LEFT JOIN` statements join the subquery (`ad`) with each individual table based on 
     *    the user ID and the corresponding source value. This ensures that all rows from the 
     *    subquery are included in the result set, even if there are no matches in the joined tables.
     * 4. The `WHERE` clause filters the rows based on a specific user ID, represented by the placeholder `?`.
     * 
     * Now let's go through the selected columns:
     * 
     * - `id`: The `COALESCE` function is used to select the first non-null value from the `id` 
     *   column of each table. It prioritizes the order of selection as `donations.id`, `followers.id`,
     *   `merch_sales.id`, and `subscribers.id`.
     * 
     * - `name`: Similar to `id`, it selects the first non-null value from the `name` column of each table.
     * 
     * - `read`: Selects the first non-null value from the `read` column of each table.
     * 
     * - `amount`: Selects the first non-null value from the `amount` column of the `donations` 
     *   table and the `price` column of the `merch_sales` table. The `NULL` value is used as a 
     *   placeholder for the columns that are not relevant to a particular table.
     * 
     * - `currency`: Selects the first non-null value from the `currency` column of the `donations` 
     *   table and the `currency` column of the `merch_sales` table.
     * 
     * - `item`: Selects the `item` column from the `merch_sales` table. It ignores 
     *   the `NULL` placeholders from other tables.
     * 
     * - `count`: Selects the `count` column from the `merch_sales` table. It ignores 
     *   the `NULL` placeholders from other tables.
     * 
     * - `message`: Selects the `message` column from the `donations` table. It ignores 
     *   the `NULL` placeholders from other tables.
     * 
     * - `tier`: Selects the `tier` column from the `subscribers` table. It ignores the 
     *   `NULL` placeholders from other tables.
     * 
     * - `event_time`: Selects the first non-null value from the `event_time` column of each table.
     * 
     * Adapted from https://stackoverflow.com/questions/28349354/sorting-and-merging-data-from-three-different-tables-in-an-efficient-way
     */
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
