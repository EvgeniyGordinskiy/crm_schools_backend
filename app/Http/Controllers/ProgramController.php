<?php
namespace App\Http\Controllers;

use App\Http\Requests\Program\ProgramRequest;

class ProgramController extends Controller
{
    public function create(ProgramRequest $request)
    {

//            $request->get('program_name'),
//            $request->get('program_description'),
//            $request->get('schedule'),
//            $request->get('repeat_time'),
//            $request->get('teacher_id')
        return $this->respondWithSuccess('ok');
    }
}