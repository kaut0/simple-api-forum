<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Athorized;
use App\Http\Resources\ForumResource;
use App\Models\ForumComments;
use App\Models\Forums;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForumCommentController extends Controller
{
    use Athorized;
    public function __construct()
    {
        return auth()->shouldUse('api');
    }

    public function index()
    {

    }

    public function show($id)
    {
        return new ForumResource(Forums::with('user:id,username', 'forumsComments')->find($id));
    }

    public function store(Request $request, $forum_id)
    {
        $this->valid($request->all());
        $user = $this->authorized();
        $user->comments()->create([
            'body' => $request->body,
            'forum_id' => $forum_id,
        ]);
        return response()->json([
            'message' => 'Berhasil',
        ], 201);
    }

    public function update(Request $request, $forum_id, $comment_id)
    {
        $forum_comment = ForumComments::with('user:id,username')->find($comment_id);
        $this->getOwnerShip($forum_comment->user_id);
        $forum_comment->update([
            'body' => $request->body,
        ]);
        return response()->json(['message' => 'berhasil merubah data', 'data' => $forum_comment], 201);
    }

    public function delete($forum_id, $comment_id)
    {
        $forum_comment = ForumComments::with('user:id,username')->find($comment_id);
        $this->getOwnerShip($forum_comment->user_id);
        $forum_comment->forumsComments()->delete();
        return response()->json(['message' => 'berhasil menghapus data'], 200);
    }

    private function valid($request)
    {
        $validator = Validator::make($request, [
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            response()->json($validator->errors())->send();
            exit;
        }
    }
}