<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'title' => 'required|string',
            'rating' => 'required|integer',
        ]);

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
