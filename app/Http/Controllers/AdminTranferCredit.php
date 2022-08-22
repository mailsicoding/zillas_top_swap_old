<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminTranferCredit extends Controller
{
    public function getPlayers(Request $request)
    {

        $all_players = User::role('Player')->get();
        return response()->json([
            'success' => true,
            'message' => "get Players all record  successfully",
            'users' => $all_players
        ]);
    }


    public function edit_Credits(Request $request)
    {
        $inputs = $request->all();
        $v = Validator::make($inputs, [
            'funds'       => 'required',

        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'message' => $v->errors()

            ]);
        }

        if (0 >= $request->funds) {
            return response()->json([
                'success' => false,
                'message' => "Funds must be grater than 0",
            ]);
        }

        $player = User::role('Player')->find($request->userId);
        if ($player) {
            $player->update([
                'funds' => $player->funds + $request->funds
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Funds Added Successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "No funds",
        ]);
    }

    public function remove_crdite(Request $request)
    {
        $inputs = $request->all();
        $v = Validator::make($inputs, [
            'funds'       => 'required',

        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'message' => ($request->is('api/*')) ? $v->errors()->first() : $v->errors()

            ]);
        }

        if (0 >= $request->funds) {
            return response()->json([
                'success' => false,
                'message' => "Funds must be grater than 0",
            ]);
        }


        $sub_player = User::role('Player')->find($request->userId);
        if ($sub_player) {

            if ($sub_player->funds < $request->funds) {
                return response()->json([
                    'success' => false,
                    'message' => "Funds must be grater than " . $sub_player->username . "'s credits",
                ]);
            }

            $sub_player->update([
                'funds' => $sub_player->funds - $request->funds
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Funds Minus Succussfully',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Funds Not Found'
        ]);
    }
}
