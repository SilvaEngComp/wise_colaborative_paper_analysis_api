<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $flag = false;

        if ($request->input('email') != "") {
            $user = User::all()->where("email", $request->input('email'))->first();
        }

        if ($user) {
            $user->update();
            if (!$token = Auth::login($user, true)) {
                return response(array("message" => 'Acesso n達o autorizado'), 403);
            }

        return $this->respondWithToken($token, $user, $request->input('now'));
        }
    }

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public  function loggedUser()
    {
        echo 'oi';
        if (Auth::check()) {
            return User::build(Auth::user());
        }

        return null;
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function checkLevelAccess($level)
    {
        if (auth()->user()) {
            if (User::getLevel(auth()->user()) <= $level) {
                return true;
            }
        }
        return false;
    }

    /* Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function valideUser(User $user)
    {
        if (Auth::id() == $user->id) {
            return true;
        }
        return false;
    }

    public static function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response(['message' => 'Successfully logged out'], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // print_r(auth());
        return $this->respondWithToken(auth()->refresh(), auth()->user());
    }

    protected function respondWithToken($token, User $user, $now)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'user' => User::buildSimple($user),
            'created_at' => $now,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
