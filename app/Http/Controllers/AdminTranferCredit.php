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
                'message' => ($request->is('api/*')) ? $v->errors()->first() : $v->errors()

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
                'player'  => $player
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "No funds",
            // 'edit_users' => $edit_player
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

        $sub_player = User::role('Player')->find($request->userId);
        if ($sub_player) {
            $sub_player->update([
                'funds' => $sub_player->funds - $request->funds
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Funds Minus Succussfully',
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Funds Not Found'
        ]);
    }
}
