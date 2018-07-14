<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AccountController extends Controller
{
    public function index()
    {
        var_dump(Request::user()->permissions()->get());
        dd(Request::user()->permissions()->get());
    }
}