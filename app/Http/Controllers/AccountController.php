<?php
namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Request;

class AccountController extends Controller
{
    public function index()
    {
        return new UserResource(Request::user());
    }
}