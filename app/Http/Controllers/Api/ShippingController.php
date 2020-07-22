<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function __invoke()
    {
        return response()->json(Shipping::getShippingOptions());
    }
}
