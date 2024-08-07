<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        $user = User::included()
                            ->filter()
                            ->sort()
                            ->getOrPaginate();

        return UserResource::collection($user);
    }
}
