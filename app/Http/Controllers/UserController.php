<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getProfile(): JsonResponse
    {
        return response()->json(Auth::user());
    }

    /**
     *
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = Auth::user();

        DB::beginTransaction();

        $user->fill($request->only(['first_name', 'last_name']));
        $user->save();

        DB::commit();

        return response()->json($user);
    }
}
