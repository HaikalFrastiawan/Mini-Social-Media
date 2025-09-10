<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;


class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_id' => 'required',
            'content' => 'required |string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $comment = Comment::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);
        return response()->json([
            'success' => true,
            'status' => 'success',
            'data' => $comment
        ], 201);
    }

    public function destroy($id)
    {
        Comment::destroy($id);
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => 'Comment deleted successfully'
        ], 200);  
        
    }
}
