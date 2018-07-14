<?php
namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AccountController extends Controller
{
    public function index()
    {
//        $user =  Request::user()->with(['role' => function ($q){
//            $q->with('permissions');
//        }])->first()->toArray();
//        return $this->respondWithData($user);
        return new UserResource(Request::user());
    }
}