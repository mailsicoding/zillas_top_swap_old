<?php

namespace App\Http\Controllers\API;

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
            'user_id' => $request->user_id,
            'offer_id' =>  ($offer)  ? $offer->id : 0,
            'match_user_id' => ($offer)  ? $offer->user_id : 0,
            'price'  =>  ($offer)  ? $offer->price : $request->price,
            'method'  =>  $request->payment_method

        ]);
        return response()->json([
            'status' => true,
            'message' => 'order saved successfully.',
        ]);
    }


    public function get_history()
    {
        $user = Auth::user();
        $get = orderBy::with('user_order', 'offer_order')->where('user_id',$user->id)->orWhere('match_user_id',$user->id)->get();
        $response = [
            'success' => true,
            'history' => $get,
            'message' => 'Order  List.',
        ];
        return response()->json($response);
    }

    public function order_cancel_history(Request $request)
    {
        $user = Auth::user();
        $get = orderBy::with('user_order', 'offer_order')->where('user_id',$user->id)->where('status','complete')->orWhere('match_user_id',$user->id)->get();
        $response = [
            'success' => true,
            'history' => $get,
            'message' => 'Order  List.',
        ];
        return response()->json($response);
    }
}
