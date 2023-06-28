<?php

namespace App\Http\Controllers;

use App\Models\MerchSale;
use Illuminate\Http\Request;

class MerchSaleController extends Controller
{
    /**
     * Return the top 3 merch items
     */
    public function topThree() {
        return MerchSale::topThree();
    }
}
