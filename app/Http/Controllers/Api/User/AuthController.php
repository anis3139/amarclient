<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Shop;
use App\Models\User;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use stdClass;

class AuthController extends Controller
{
    public function register(Request $request)
    {
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();

        try {
            $shop = Shop::create([
                'name' => $request->shop_name,
            ]);
            $request['password'] = Hash::make($request['password']);
            $user = User::create([
                'shop_id' => $shop->id,
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => $request['password'],
            ]);

            $user->generateTwoFactorCode();
            $user->notify(new TwoFactorCode());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errors' => $e->getMessage()],422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registration success.',
            'verify_link' => route('shop.api.email.verify'),
        ],Response::HTTP_CREATED);
    }
    public function verifyEmail(Request $request)
    {
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'verification_code' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $user = User::where('email',$request->email)->with('shop')->first();
        if (!$user){
            $object = new stdClass;
            $object->verification_code = 'No account found!';
            return response()->json(['success' => false, 'message' => $object], 422);
        }
        if ($user->two_factor_verified_at != null && $user->two_factor_code === null) {
            return new JsonResponse(['success' =>false, 'message' => 'Email already verified.']);
        }

        $accessToken = $user->createToken('authToken',['user'])->accessToken;
        if($request->verification_code == $user->two_factor_code)
        {
            $user->markAsVerified();
            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully.',
                'access_token' => $accessToken,
                'userData' => new UserResource($user),
            ]);
        }
        $object = new stdClass;
        $object->verification_code = 'Verification code does not match.';
        return response()->json([
            'success' => false,
            'errors' => $object,
            'resend_code_link'=> route('shop.api.code.resend'),
        ],322);
    }

    public function codeResend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $user = User::where('email',$request->email)->first();
        if (!$user){
            return response()->json(['success' => false, 'message' => 'No account found!'], 422);
        }
        if ($user->two_factor_verified_at != null && $user->two_factor_code === null) {
            return new JsonResponse(['success' =>false, 'message' => 'Email already verified.']);
        }
//        $user = Auth::guard('user-api')->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
        return new JsonResponse([
            'success' => true,
            'message' => 'New verification code sent.',
            'verify_link' => route('shop.api.email.verify'),
        ]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email',$request->email)->first();
            if ($user->two_factor_verified_at === null && $user->two_factor_code != null) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Verify your email first.',
                    'verify_link' => route('shop.api.email.verify'),]);
            }
            $accessToken = $user->createToken('authToken',['user'])->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'Login success',
                'access_token' => $accessToken,
                'userData' => new UserResource(Auth::guard('user')->user()),
            ],Response::HTTP_ACCEPTED);
        }

        return response()->json(['success' => false, 'errors' => 'email or password incorrect',],Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['success' => true, 'message' => 'Logout successfully']);
    }

    public function getAllUsers()
    {
        return User::all();
    }

    public function getLoggedUserDetails()
    {
        $user = auth('user-api')->user();
        if (!$user){
            return \response()->json(['success'=>false,'user'=>$user]);
        }
        return \response()->json(['success'=>true,'user'=>$user]);
    }
}
