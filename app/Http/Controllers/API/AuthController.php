<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
            'userAgent' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        auth()->shouldUse('admin');

        if (!auth()->attempt($validator->validate())) {
            return $this->errorResponse(['wrong Credentials']);
        }

        $userToken = auth()->user()->createToken($request->post('userAgent', $request->userAgent()));

        return $this->successResponse([
            'token' => $userToken->plainTextToken,
            'user' => auth()->user()
        ]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function destroy()
    {
        try {

            auth()->user()->currentAccessToken()->delete();
        }catch (\Exception $exception){
            return $this->errorResponse('error while logging out');
        }

        return $this->successResponse(['message' => 'Done']);
    }
}
