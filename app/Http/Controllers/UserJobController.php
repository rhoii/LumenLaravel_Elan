<?php

namespace App\Http\Controllers;

//use App\User;
use App\Models\UserJob; // Your model is located inside Models Folder
use Illuminate\Http\Response; // Response Components
use App\Traits\ApiResponser; // Use to standardize our code for API response
use Illuminate\Http\Request; // Handling HTTP request in Lumen
use DB; // If you're not using Lumen Eloquent, you can use DB component in Lumen

class UserJobController extends Controller
{
    // Use to add your Traits ApiResponser
    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the list of usersjob
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $usersjob = UserJob::all();
        return $this->successResponse($usersjob);
    }

    /**
     * Obtains and show one userjob
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $userjob = UserJob::findOrFail($id);    
        return $this->successResponse($userjob);
    }
}