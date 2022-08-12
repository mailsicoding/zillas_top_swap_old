<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\method;
use App\Models\Offers\Offers;
use App\Models\Operator;
use App\Models\User;
use App\Models\orderBy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{

    public function getoffers()
    {
        $offers = Auth::user()->user_offers;
        $data = [];
        foreach ($offers as $offer) {
            if ($offer->status == 'open') {
                $off = [];
                $off['id'] = $offer->id;
                $off['price'] = $offer->price;
                $off['methods'] = $offer->offer_methods->pluck('name')->toArray();
                $data[] = $off;
            }
        }
        $response = [
            'success' => true,
            'offers' => $data,
            'message' => 'Offers List.',
        ];
        return response()->json($response);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $inputs = $request->all();
        $v = Validator::make($inputs, [
            'price'       => 'required',
            'methods'   => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'message' => ($request->is('api/*')) ? $v->errors()->first() : $v->errors()

            ]);
        }

        if($user->funds < $request->price)
        {
            return response()->json([
                'status' => false,
                'message' => ($request->is('api/*')) ? 'Offer price must be less than your available credits.' : [
                    'price' => [
                        'Offer price must be less than your available credits.'
                    ]
                ]

            ]);
        }

        $offer = Offers::create([
            'user_id' => $user->id,
            'price' => $request->price,
        ]);
        foreach ($inputs['methods'] as $method) {
            if ($method === 'apple_pay') {
                $meth = method::where('name', 'apple_pay')->first();
                $offer->offer_methods()->attach($meth->id);
            } else if ($method === 'chime') {
                $meth = method::where('name', 'chime')->first();
                $offer->offer_methods()->attach($meth->id);
            } else if ($method === 'venmo') {
                $meth = method::where('name', 'venmo')->first();
                $offer->offer_methods()->attach($meth->id);
            } else if ($method === 'square_cash') {
                $meth = method::where('name', 'square_cash')->first();
                $offer->offer_methods()->attach($meth->id);
            } else if ($method === 'paypal') {
                $meth = method::where('name', 'paypal')->first();
                $offer->offer_methods()->attach($meth->id);
            } else if ($method === 'zelle') {
                $meth = method::where('name', 'zelle')->first();
                $offer->offer_methods()->attach($meth->id);
            }
        }
        $data = [
            'success' => true,
            'message' => 'Offer Created Successfully.',
        ];
        return response()->json($data);
    }

    public function remove(Request $request)
    {
        $offer = Offers::find($request->offerId);
        if ($offer) {
            $offer->delete();
            $data = [
                'success' => true,
                'message' => 'Offer Deleted Successfully.',
            ];
            return response()->json($data);
        }
        $data = [
            'success' => false,
            'message' => 'Offer Not Found.',
        ];
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $offer = Offers::find($request->offerId);
        if ($offer) {
            $methods = $offer->offer_methods->pluck('name')->toArray();
            $data = [
                'success' => true,
                'offer' => [
                    'price' => $offer->price,
                    'methods' => $methods,
                ],
                'message' => 'Offer.',
            ];
            return response()->json($data);
        }
        $data = [
            'success' => false,
            'message' => 'Offer Not Found.',
        ];
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $inputs = $request->all();
        $v = Validator::make($inputs, [
            'price'       => 'required',
            'methods'   => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'message' => ($request->is('api/*')) ? $v->errors()->first() : $v->errors()

            ]);
        }

        if($user->funds < $request->price)
        {
            return response()->json([
                'status' => false,
                'message' => ($request->is('api/*')) ? 'Offer price must be less than your available credits.' : [
                    'price' => [
                        'Offer price must be less than your available credits.'
                    ]
                ]

            ]);
        }
        $offer = Offers::find($request->offerId);
        if ($offer) {
            $offer->offer_methods()->detach();
            foreach ($inputs['methods'] as $method) {
                if ($method === 'apple_pay') {
                    $meth = method::where('name', 'apple_pay')->first();
                    $offer->offer_methods()->attach($meth->id);
                } else if ($method === 'chime') {
                    $meth = method::where('name', 'chime')->first();
                    $offer->offer_methods()->attach($meth->id);
                } else if ($method === 'venmo') {
                    $meth = method::where('name', 'venmo')->first();
                    $offer->offer_methods()->attach($meth->id);
                } else if ($method === 'square_cash') {
                    $meth = method::where('name', 'square_cash')->first();
                    $offer->offer_methods()->attach($meth->id);
                } else if ($method === 'paypal') {
                    $meth = method::where('name', 'paypal')->first();
                    $offer->offer_methods()->attach($meth->id);
                } else if ($method === 'zelle') {
                    $meth = method::where('name', 'zelle')->first();
                    $offer->offer_methods()->attach($meth->id);
                }
            }
            $offer->update([
                'price' => $request->price,
            ]);

            $data = [
                'success' => true,
                'message' => 'Offer Updated Successfully.',
            ];
            return response()->json($data);
        }
        $data = [
            'success' => false,
            'message' => 'Offer Not Found.',
        ];
        return response()->json($data);
    }

    public function match_offers(Request $request)
    {

        $user = Auth::user();
        $inputs = $request->all();
        $seller_offers = Offers::with('users')->where('user_id', '!=', $user->id)->where('status', '=', 'open')->latest()->get();
        $buy_methods = [];
        foreach ($inputs['methods'] as $method) {
            if ($method === 'apple_pay') {
                $buy_methods[] = method::where('name', 'apple_pay')->first();
            } else if ($method === 'chime') {
                $buy_methods[] = method::where('name', 'chime')->first();
            } else if ($method === 'venmo') {
                $buy_methods[] = method::where('name', 'venmo')->first();
            } else if ($method === 'square_cash') {
                $buy_methods[] = method::where('name', 'square_cash')->first();
            } else if ($method === 'paypal') {
                $buy_methods[] = method::where('name', 'paypal')->first();
            } else if ($method === 'zelle') {
                $buy_methods[] = method::where('name', 'zelle')->first();
            }
        }
        $matched_offer = [];
        $matched_methods = [];
        foreach ($seller_offers as $sell_off) {
            $sell_methods = $sell_off->offer_methods->toArray();
            if ($sell_off->price == $request->price) {
                $buy_methods_key = array_column($buy_methods, 'name');
                $sell_methods_key = array_column($sell_methods, 'name');
                $intersectedValues = array_intersect($buy_methods_key, $sell_methods_key);
                if ($intersectedValues) {
                    $matched_offer[] = $sell_off;
                    $matched_methods[] = $intersectedValues;
                    break;
                }
            }
        }
        if ($matched_offer == [] && $matched_methods == []) {
            $data = [
                'success' => false,
                'offer' => [
                    'offer' => (object) [],
                    'matched_methods' => [],
                ],
                'message' => 'Offer not matched. Chat with staff',
            ];
        } else {
            $o = $matched_offer[0];
            $o->update(['status' => 'matched', 'match_user_id'=>Auth::user()->id]);
            $data = [
                'success' => true,
                'offer' => [
                    'offer' => $matched_offer[0],
                    'matched_methods' => $matched_methods[0],
                ],
                'message' => 'Offer Matched.',
            ];
        }

        return response()->json($data);
    }

    public function get_match_offers(Request $request)
    {
        $offer = Offers::find($request->offerId);
        $offer->match_user_id = Auth::user()->id;
        $offer->save();
        $user = User::find($offer->user_id)->only(['id','username','isLogin']);
        return $user;
    }

    public function get_match_status(Request $request)
    {
        $user = Auth::user();
        $offer = Offers::where('user_id', $user->id)->where('status', 'matched')->first();
        if ($offer) {
            return response()->json([
                'status' => true,
                'offer' => [
                    'offer' => $offer,
                    'matched_methods' => $offer->offer_methods->pluck('name')->toArray(),
                ],
            ]);
        }
        return response()->json([
            'status' => false,
            'offer' => (object) [],
        ]);
    }

    public function trade_cancel(Request $request)
    {
        $offer = Offers::find($request->offerId);
        if ($offer) {

            $history = orderBy::create([
                'user_id' => $request->user_id,
                'offer_id' =>  $offer->id,
                'match_user_id' => $offer->user_id,
                'price'  =>  $offer->price,
                'method'  =>  '-'

            ]);

            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }

    public function find_operator(Request $request)
    {
        $operators = Operator::whereStatus(0)->get();
        $operator = (object) [];
        foreach($operators as $o)
        {
            $operator = User::where('id',$o->operator_id)->where('isLogin',1)->first();
            if(!empty($operator))
            {
                $o->delete();
                Operator::create(['operator_id' => $operator->id, 'status' => 1]);
                break;
            }
        }
        return $operator;
    }

    public function change_operator_status(Request $request)
    {
        if($request->id)
        {
            $operator = Operator::whereOperatorId($request->id)->first();
            $operator->update([ 'status' => 0]);
            return response()->json([
                'status' => true,
                'message' => 'Status Updated Successfully.',
            ]);
        }
        $user = Auth::user();
        $operator = Operator::whereOperatorId($user->id)->first();
        $operator->update([ 'status' => 0]);
        return response()->json([
            'status' => true,
            'message' => 'Status Updated Successfully.',
        ]);
    }

    public function change_offer_status(Request $request)
    {
        $offer = Offers::whereId($request->id)->first();
        $offer->update([ 'status' => 'open']);
        return response()->json([
            'status' => true,
            'message' => 'Status Updated Successfully.',
        ]);
    }

    public function get_buyer(Request $request)
    {
            $user = User::where('id',$request->buyer_id)->first();
            if(!empty($user))
            {
                return response()->json([
                    'status' => true,
                    'buyer' => $user->only(['id','username'])
                ]);
            }
            return response()->json([
                'status' => false,
                'buyer' => (object) [],
            ]);
    }

    public function get_seller(Request $request)
    {
            $user = User::where('id',$request->seller_id)->first();
            if(!empty($user))
            {
                return response()->json([
                    'status' => true,
                    'seller' => $user->only(['id','username'])
                ]);
            }
            return response()->json([
                'status' => false,
                'seller' => (object) [],
            ]);
    }
    public function get_operator(Request $request)
    {
            $user = User::where('id',$request->operator_id)->first();
            if(!empty($user))
            {
                return response()->json([
                    'status' => true,
                    'operator' => $user->only(['id','username'])
                ]);
            }
            return response()->json([
                'status' => false,
                'operator' => (object) [],
            ]);
    }

    public function get_admin_username(Request $request)
    {
            $user = User::find(1);
            if(!empty($user))
            {
                return $user->username;
            }
            return '';
    }

}
