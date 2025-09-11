<?php

namespace App\Http\Controllers;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $like = Like::create([
            'post_id' => $request->post_id,
            'user_id' => $request->user_id,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Like created successfully',
            'data' => $like
        ], 201);
    }

    public function destroy($id)
    {
        $like = Like::find($id);

        if (!$like) {
            return response()->json([
                'error' => 'Like not found'
            ], 404);
        }

        $like->delete();

        return response()->json([
            'message' => 'Like deleted successfully'
        ], 200);
    }
}
