<?php

namespace App\Http\Controllers;

use App\Models\UserJob; // Your model is located inside the Models folder
use Illuminate\Http\Response; // Response components
use App\Traits\ApiResponser; // Used to standardize API responses
use Illuminate\Http\Request; // Handles HTTP requests in Lumen
use DB; // If you're not using Lumen Eloquent, you can use DB component in Lumen

class UserJobController extends Controller
{
    use ApiResponser; // Adds the ApiResponser Trait

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the list of user jobs
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $usersjob = UserJob::all();
        return $this->successResponse($usersjob);
    }

    /**
     * Obtains and shows one user job
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $userjob = UserJob::findOrFail($id);
        return $this->successResponse($userjob);
    }
}