<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\VerificationMail;
use App\Models\Operator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Twilio\Rest\Client;
use \Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function index(){
        $user = Auth::user();
        $role = $user->roles()->first();
        if($role->name == "Player" || $role->name == "Operator")
        {
            return response()->json([
                'success' => true,
                'message' => "get all records successfully",
                'users'=> [User::with('roles')->whereId($user->id)->first()]
            ]);
        }
        $all_users = User::with('roles')->whereNotIn('id',[1])->get();
        return response()->json([
            'success' => true,
            'message' => "get all records successfully",
            'users'=>$all_users
        ]);
    }

    public function getOperators(){
        $all_users = User::role('Player')->get();
        return response()->json([
            'success' => true,
            'message' => "get all records successfully",
            'users'=>$all_users
        ]);
    }

    public function get_player_count(){
        $players = User::role('Player')->get();
        return count($players);
    }
    public function get_operator_count(){
        $Operators = User::role('Operator')->get();
        return count($Operators);
    }

    public function edit_user(Request $request){
        $user = User::find($request->userId);
        if($user)
        {

            $data = [
                'success' => true,
                'user' => [
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->roles
                ],
                'message' => (object) [],
            ];
            return response()->json($data);
        }
        $data = [
            'success' => false,
            'message' => 'User Not Found.',
        ];
        return response()->json($data);
    }
    public function signup(Request $request)
    {
        $inputs = $request->all();
        $v = Validator::make($inputs, [
            'username' => 'required|string|alpha_dash|min:3|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => ($request->is('api/*')) ? $v->errors()->first() : $v->errors(),
                'user'=>(object) []
            ]);
        }

        $user = User::create([
            'username' => $inputs['username'],
            'email' => $inputs['email'],
            'phone' => $inputs['phone'],
            'password' => Hash::make($inputs['password']),
        ]);

        Auth::login($user);

        $this->sendMessage($user);
        $this->sendEmail($user);

        $token = $user->createToken($user->email)->plainTextToken;

        $role = Role::find(1);
        $user->assignRole($role->name);
        // $role->givePermissionTo(['Dashboard','Account Setting']);


        $u = User::find($user->id)->only(['id','username','email','phone','is_email_verified','is_phone_verified']);
        $u['token'] = $token;
        $u['role'] = $user->roles()->first()->name;

        return response()->json([
            'success' => true,
            'message' => 'User registered Successfully.',
            'user' => $u,
        ]);
    }

    public function store_user(Request $request)
    {

        $inputs = $request->all();
        $inputs['phone'] = $inputs['code'].$inputs['phone'];
        $v = Validator::make($inputs, [
            'username' => 'required|string|alpha_dash|min:3|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors(),
            ]);
        }
        $user = User::create([
            'username' => $inputs['username'],
            'email' => $inputs['email'],
            'phone' => $inputs['phone'],
            'password' => Hash::make($inputs['password']),
        ]);

        if($inputs['role'] == 2)
        {
            Operator::create(['operator_id' => $user->id]);
        }

        $role = Role::whereId($inputs['role'])->pluck('name');

        $user->assignRole($role);

        return response()->json([
            'success' => true,
            'users'=>$user,
            'message' => 'User Add Successfully.',
        ]);
    }
    public function delete_user(Request $request){
        // dd($request->user_id);
        $user= User::find($request->user_id)->delete();
        if($user)
        {
        $data = [
            'success' => true,
            'message' => 'Delete User Successfully.',
        ];
        }
        else{
            $data = [
                'success' => false,
                'message' => 'User Not Found',
            ];
        }
        return response()->json($data);

    }
    public function update(Request $request)
    {

        $inputs = $request->all();
        $inputs['phone'] = $inputs['code'].$inputs['phone'];
        $v = Validator::make($inputs, [
            'username' => 'required|string|alpha_dash|min:3|unique:users,username,'.$inputs['userId'],
            'email' => 'required|email|unique:users,email,'.$inputs['userId'],
            'phone' => 'required|unique:users,phone,'.$inputs['userId'],
            'role' => 'required',
            'password' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors(),
            ]);
        }
        $user = User::find($inputs['userId']);
        if($user){
            $user->update([
                'username' => $inputs['username'],
                'email' => $inputs['email'],
                'password' => $inputs['password'],
                'phone' => $inputs['phone'],
                'password' => Hash::make($inputs['password']),
            ]);

            if($user->roles()->first()->name == 'Operator' && $inputs['role'] != 2)
            {
                $o = Operator::where('operator_id', $user->id)->first();
                if($o)
                {
                    $o->delete();
                }
            }

        }

        if($inputs['role'] == 2)
        {
            $o = Operator::where('operator_id', $user->id)->first();
            if(!$o)
            {
                Operator::create(['operator_id' => $user->id]);
            }
        }

        $role = Role::whereId($inputs['role'])->pluck('name');

        $user->syncRoles([$role]);

        if($user)
        {
        $data = [
            'success' => true,
            'message' => 'Update User Successfully.',
        ];
        }
        else{
            $data = [
                'success' => false,
                'message' => 'User Not Found',
            ];
        }
        return response()->json($data);
    }

    public function login(Request $request)
    {
        $inputs = $request->all();
        $v = Validator::make($inputs, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => ($request->is('api/*')) ? $v->errors()->first() : $v->errors(),
                'user' => (object) [],
            ]);
        }
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();



            // User online or not
            $u= User::find($user->id);
            $u->isLogin = true;
            $u->save();

            $token = $user->createToken($user->email)->plainTextToken;

            $user1 = User::find($user->id)->only(['username','email','phone','is_email_verified','is_phone_verified','id','image',]);
            $user1['token'] = $token;
            $user1['role'] = $u->roles()->first()->name;

            return response()->json([
                'success' => true,
                // 'errors' => (object) [],
                'message' => 'User Login Successfully.',
                'user' => $user1,
            ]);
        }
        return response()->json([
            'success' => false,
            // 'errors' =>  ['email' => 'Invalid Email / Password'],
            'message' => 'Invalid Email / Password',
            'user' => (object) [],
        ]);
    }
    public function save_fcm_token(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'fcm_token' => $request->fcm_token
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FCM token saved successfully.',
        ]);
    }

    public function sendMessage(User $user)
    {
        $receiverNumber = $user->phone;
        $code = rand(100000,999999);
        // $code = '123456';
        $message = "Your Zilla's Top Swap Verification Code is ".$code;

        $account_sid = env("TWILIO_SID");
        $auth_token = env("TWILIO_TOKEN");
        $twilio_number = env("TWILIO_FROM");

        $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message]);

        $user->update([
            'phone_code' => $code
        ]);
    }

    public function sendEmail(User $user)
    {
        $code = rand(100000,999999);
        // $code = '123456';

        $user->update([
            'email_code' => $code
        ]);

        Mail::to($user->email)->send(new VerificationMail($user, $code));
    }

    public function send_phone_verification_code()
    {
        $user = Auth::user();

        $receiverNumber = $user->phone;

        $this->sendMessage($user);

        return response()->json([
            'success' => true,
            'message' => 'We sent a verification code to '.$receiverNumber,
        ]);

    }


    public function verify_phone_verification_code(Request $request)
    {
        $v = Validator::make($request->all(), [
            'code' => 'required|integer'
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors()->first(),
            ]);
        }

        $user = Auth::user();

        if($user->phone_code === $request->code)
        {
            $user->update([
                'phone_code' => null,
                'is_phone_verified' => 1
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Phone Verified Successfully.',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid Code.',
        ]);
    }


    public function send_email_verification_code()
    {
        $user = Auth::user();

        $this->sendEmail($user);

        return response()->json([
            'success' => true,
            'message' => 'We sent a verification code to '.$user->email,
        ]);

    }


    public function verify_email_verification_code(Request $request)
    {
        $v = Validator::make($request->all(), [
            'code' => 'required|integer'
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors()->first(),
            ]);
        }

        $user = Auth::user();

        if($user->email_code === $request->code)
        {
            $user->update([
                'email_code' => null,
                'is_email_verified' => 1
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Email Verified Successfully.',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid Code.',
        ]);
    }

    public function send_forget_email_code(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors(),
            ]);
        }

        $email = $request->email;

        $user = User::where('email',$email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email does not match our record',
            ]);
        }

        $code = rand(100000,999999);

        $user->update([
            'email_code' => $code,
            'request_token' => Str::random(30),
        ]);

        $token = Str::random(30);

        $user->update([
            'email_code' => $code,
            'request_token' => $token,
        ]);

        Mail::to($user->email)->send(new VerificationMail($user, $code));

        return response()->json([
            'success' => true,
            'request_token' => $token,
            'message' => 'We sent a verification code to '.$user->email,
        ]);

    }

    public function verify_forget_email_code(Request $request)
    {
        $v = Validator::make($request->all(), [
            'code' => 'required|integer'
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors(),
            ]);
        }

        $email = $request->email;
        $code = $request->code;
        $request_token = $request->request_token;

        $user = User::where('email',$email)
                    ->where('email_code',$code)
                    ->where('request_token',$request_token)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Code',
            ]);
        }

        $token = Str::random(30);

        $user->update([
            'email_code' => null,
            'request_token' => null,
            'reset_token' => $token,
        ]);


        $user->update([
            'email_code' => $code,
            'reset_token' => $token,
        ]);

        return response()->json([
            'success' => true,
            'reset_token' => $token,
            'message' => 'Email Verified Successfully.',
        ]);

    }

    public function update_password(Request $request)
    {
        $v = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'max:12'],
            'confirm_password' => 'required|same:password|min:6'
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors(),
            ]);
        } else {
            $email = $request->email;
            $request_token = $request->reset_token;
            $user = User::where('email',$email)
                    ->where('reset_token',$request_token)->first();
            if (!($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something Went Wrong. Try Again',
                ]);
            } else {
                $user->password = bcrypt(trim($request->password));
                if ($user->save()) {
                    $user->update([
                        'reset_token' => null
                    ]);
                    return response()->json([
                        'success' => true,
                        'message' => 'password updated successfully',
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Something Went Wrong. Try Again.',
                ]);
            }
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        $user->update(['isLogin' => false]);

        if($user){
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success' => true,
                'message' => "Logout Successfully",
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => "user must be login first",
            ]);
        }


    }
    public function get_roles(){
        $roles =  Role::with('permissions')->get();
        return response()->json([
            'success' => true,
            'message' => "get all records successfully",
            'roles'=>$roles
        ]);
    }
    public function edit_roles(Request $request){
        $role =  Role::find($request->roleId);
        $permissions = $role->permissions()->pluck('id')->toArray();
        return response()->json([
            'success' => true,
            'message' => "get all records successfully",
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }
    public function get_permissions(Request $request){
        $all_perm = Permission::all();
        return PermissionResource::collection($all_perm);
    }
    public function assign_permission_role(Request $request){
        $role = Role::find($request->roleId);
        $data = [];
        foreach( $request->permissions as $key=>$permission ) {
               $data[]= Permission::find($permission);
        }
        $role->syncPermissions($data);
        return response()->json([
            'success' => true,
            'message' => "Assign Permissions successfully",
        ]);
    }
    public function search_admin_chat(Request $request){
        $users = User::where('username', 'LIKE', "%{$request->name}%")->get();
        return response()->json(['users'=>$users]);
    }

}
