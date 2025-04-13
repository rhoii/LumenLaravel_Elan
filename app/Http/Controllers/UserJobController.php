<?php

namespace App\Http\Controllers;

use App\Models\UserJob;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponser;
use DB;

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
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $usersjob = UserJob::all();
        return $this->successResponse($usersjob);
    }

    /**
     * Obtains and shows one user job
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $userjob = UserJob::findOrFail($id);
        return $this->successResponse($userjob);
    }
}
