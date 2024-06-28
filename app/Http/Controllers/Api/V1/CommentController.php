<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'tour_package_id' => 'required|exists:tour_packages,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'title' => 'required|string',
            'rating' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => Helpers::error_processor($validated)
            ], 403);
        };

        Comment::create([
            'tour_package_id' => $validated['tour_package_id'],
            'user_id' => $validated['user_id'],
            'content' => $validated['content'],
            'title' => $validated['title'],
            'rating' => $validated['rating'],
        ]);

        $msg = 'Comentario creado correctamente.';
        return response()->json(['msg' => $msg], 200);
    }

    public function index($user_id)
    {
        $comments = Comment::where('user_id', $user_id)->get();
        return response()->json($comments);
    }
}
