<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

// Importing User Model
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();

            if ($users->count() > 0) {
                return response()->json([
                    'data' => $users,
                    'message' => 'Users retrieved successfully'
                ], JsonResponse::HTTP_OK);
            } else {
                return response()->json([
                    'data' => [],
                    'message' => 'No users found'
                ], JsonResponse::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Create a New User
        try {
            $users = User::create($request->all());
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $users,
            'message' => 'Successful'
        ], JsonResponse::HTTP_OK);
    }

    public function show($id)
    {
        // Fetch Specific user
        try{
            $user = User::find($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $user,
            'message' => 'User Found Successfully'
        ], JsonResponse::HTTP_OK);
    }


    public function update(Request $request, $id)
    {
        // Update Specific User
        try {
            $user = User::find($id);
            $user->update($request->all());
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $user,
            'user' => $id,
            'requestParams' => $request->all(),
            'message' => 'Update User Success'
        ], JsonResponse::HTTP_OK);
    }

    public function destroy($id)
    {
        // Delete Specific User
        try { 
            $user = User::destroy($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $user,
            'message' => 'Delete User Success'
        ], JsonResponse::HTTP_OK);
    }
}
