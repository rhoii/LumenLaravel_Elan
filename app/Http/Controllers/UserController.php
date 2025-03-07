<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    public function index()
    {
        $users = User::all();
        return $this->successResponse($users);
    }

    public function getUsers()
    {
        $users = User::all();
        return $this->successResponse($users);
    }

    public function add(Request $request)
{
    $rules = [
        'username' => 'required|max:20',
        'password' => 'required|max:20',
        'gender' => 'required|in:Male,Female',
    ];

    $this->validate($request, $rules);
    $user = User::create($request->all());
    return $this->successResponse($user, Response::HTTP_CREATED);
}


    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return $this->successResponse($user);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('User ID does not exist', Response::HTTP_NOT_FOUND);
        }
    }   

    public function update(Request $request, $id)
    {
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender' => 'in:Male,Female',
        ];

        $this->validate($request, $rules);

        try {
            $user = User::findOrFail($id);
            $user->fill($request->all());

            if ($user->isClean()) {
                return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user->save();
            return $this->successResponse($user);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('User ID does not exist', Response::HTTP_NOT_FOUND);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return $this->successResponse(['message' => 'User deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('User ID does not exist', Response::HTTP_NOT_FOUND);
        }
    }
}
