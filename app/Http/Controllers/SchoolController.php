<?php
namespace App\Http\Controllers;

use App\Http\Requests\School\CreateSchoolRequest;
use App\Http\Resources\SchoolResource;
use App\Models\School;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function create(CreateSchoolRequest $request)
    {
        $school = new School([
            'name' => $request->get('name'),
            'description' => $request->get('description', ''),
            'address' => $request->get('address', ''),
            'owner' => Auth::id()
        ]);
        $school->save();
        return new SchoolResource($school);
    }
}