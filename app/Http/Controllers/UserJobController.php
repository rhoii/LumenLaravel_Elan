<?php

namespace App\Http\Controllers;

use App\Models\UserJob;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserJobController extends Controller
{
    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the list of user jobs
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userJobs = UserJob::all();
        return $this->successResponse($userJobs);
    }

    /**
     * Get a single user job by ID
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $userJob = UserJob::findOrFail($id);
            return $this->successResponse($userJob);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('UserJob ID does not exist', Response::HTTP_NOT_FOUND);
        }
    }
}
