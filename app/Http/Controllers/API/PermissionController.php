<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function getPermissions() {
        $user = Auth::user();
        $role = $user->roles()->first();
        // $role =  Role::where($request->roleId);
        return $permissions = $role->getPermissionNames();//->pluck('name')->toArray();
        return response()->json([
            'permissions' => $permissions
        ]);
    }

    function getRole() {
        $user = Auth::user();
        $role = $user->roles()->first();
        return $role->name;
    }

    function change_photo(Request $request) {
        $user = Auth::user();
        $v = Validator::make($request->all(),[
            'profile_image' => 'required|image'
        ]);
        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors()->first(),
                'user' => (object) []
            ]);
        }

        $imageName = time().'.'.$request->profile_image->extension();
        $request->profile_image->move(public_path('images'), $imageName);


        $user->update([
            'image' => url('images/' . $imageName)
        ]);

        $request->user()->currentAccessToken()->delete();

        $token = $user->createToken($user->email)->plainTextToken;
        $user1 = User::find($user->id)->only(['username', 'email', 'phone', 'is_email_verified', 'is_phone_verified', 'id', 'image',]);
        $user1['token'] = $token;
        $user1['role'] = $user->roles()->first()->name;

        return response()->json([
            'success' => true,
            'message' => 'Profile Image updated successfully.',
            'user' => $user1
        ]);
    }
}
