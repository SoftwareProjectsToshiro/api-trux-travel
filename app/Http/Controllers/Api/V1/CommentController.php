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
            'content_' => 'required|string',
            'title' => 'required|string',
            'rating' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => Helpers::error_processor($validated)
            ], 403);
        }

        $comment = new Comment();
        $comment->tour_package_id = $request->tour_package_id;
        $comment->user_id = $request->user_id;
        $comment->content = $request->content_;
        $comment->title = $request->title;
        $comment->rating = $request->rating;
        $comment->save();

        $msg = 'Comentario creado correctamente.';
        return response()->json(['msg' => $msg], 200);
    }

    public function index($user_id)
    {
        $comments = Comment::where('user_id', $user_id)->get();
        return response()->json($comments);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(),[
            'content_' => 'required|string',
            'rating' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => Helpers::error_processor($validated)
            ], 403);
        }

        $comment = Comment::find($id);
        $comment->content = $request->content_;
        $comment->rating = $request->rating;
        $comment->save();

        $msg = 'Comentario actualizado correctamente.';
        return response()->json(['msg' => $msg], 200);
    }
}
