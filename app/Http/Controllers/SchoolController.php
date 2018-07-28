<?php
namespace App\Http\Controllers;

use App\Http\Requests\School\CreateSchoolRequest;
use App\Http\Resources\SchoolResource;
use App\Models\School;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function create(CreateSchoolRequest $request, AuthService $authService)
    {
        $school = new School([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'owner' => Auth::id()
        ]);
        $school->save();
        return new SchoolResource($school);
    }
}