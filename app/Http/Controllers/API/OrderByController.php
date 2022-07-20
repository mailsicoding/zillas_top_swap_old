<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offers\Offers;
use App\Models\orderBy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderByController extends Controller
{
    //

    public function order_history(Request $request)
    {
        $offer = Offers::find($request->offer_id);
        $user = Auth::user();
        $inputs = $request->all();
        $v = Validator::make($inputs, [
            'user_id' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => ($request->is('api/*')) ? $v->errors()->first() : $v->errors(),
                'user' => (object) []
            ]);
        }

        $history = orderBy::create([
            'user_id' => $user->id,
            'offer_id' =>  $offer->id,
            'match_user_id' => $offer->user_id,
            'price'  =>  $offer->price

        ]);
        return response()->json([
            'status' => true,
            'history' => $history,
            'user_id' => $user,
            'offers' => $offer
        ]);
    }


    public function get_history()
    {
        // $user = Auth::user();
        $get = orderBy::with('user_order', 'offer_order')->get();
        $response = [
            'success' => true,
            'history' => $get,
            'message' => 'Order  List.',
        ];
        return response()->json($response);
    }

    public function hide_cancel(Request $request)
    {
        $offer = Offers::where($request->offer_id)->orWhere(['status' => 'open'])->get();
        $gethidden = orderBy::with('user_order', 'offer_order')->get();

        $response = [
            'success' => true,
            'history' => $gethidden,
            'not_cancel' => $offer,
            'message' => 'Order  List.',
        ];
        return response()->json($response);
    }
}
