<?php

namespace App\Http\Controllers;

use App\Domain\Auth\DTO\UserCreateData;
use App\Domain\Auth\Repositories\UserRepository;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    private UserRepository $userRepository;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Wrong email or password. Please try again.'],  401); // Unauthorized
        }

        return $this->respondWithToken($token);
    }

    /**
     * Create new Client User and get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registration(UserCreateRequest $request)
    {
        $user = $this->userRepository->create(UserCreateData::fromRequest($request));
        if (!$token = auth()->attempt($request->only(['email', 'password']))) {
            return response()->json(['message' => 'Failed to generate token.'],  500);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json([
            'user' => new UserResource(auth()->user()->load('role'))
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
