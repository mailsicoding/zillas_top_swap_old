<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function getPermissions() {
        $user = Auth::user();
        $role = $user->roles()->first();
        // $role =  Role::where($request->roleId);
        $permissions = $role->permissions()->pluck('name')->toArray();
        return response()->json([
            'permissions' => $permissions
        ]);
    }
}
