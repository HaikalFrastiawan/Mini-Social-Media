<?php

namespace App\Http\Controllers;


use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'message_content' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        //lanjut validasi ok
        $message = Message::create(
            [
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'message_content' => $request->message_content,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => $message
        ], 201);
    }

    public function show(int $id)
    {
      $message = Message::find($id);
        if ($message) {
            return response()->json([
                'success' => true,
                'data' => $message
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 404);
        }
    }

    public function getMessage(int $user_id)
    {
      $messages = Message::where('receiver_id', $user_id)->get();
    
      return response()->json([
          'success' => true,
          'message' => 'Messages retrieved successfully',
          'data' => $messages
      ], 200);
    
    }
    




    public function destroy(int $id)
    {
        Message::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully'
        ], 200);        
    }   


}

