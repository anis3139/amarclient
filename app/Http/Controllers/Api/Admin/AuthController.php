<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Admin::where('email',$request->email)->first();
            $accessToken = $user->createToken('authToken',['admin'])->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successfully.',
                'access_token' => $accessToken,
                'userData' => $user,
            ]);
        }

        return response()->json(['success' => false, 'errors' => 'email or password incorrect',],Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully'
        ]);
    }

    public function getAllAdmins()
    {
        return Admin::all();
    }

    public function getLoggedUserDetails()
    {
        return auth('admin-api')->user();
    }
}
