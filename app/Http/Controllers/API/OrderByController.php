<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offers\Offers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderByController extends Controller
{
    //

    public function order_history(Request $request)
    {
        $offer = Offers::find($request->offerId);
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'history' => $user
        ]);
    }
}
