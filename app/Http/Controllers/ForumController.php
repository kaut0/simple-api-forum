<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Athorized;
use App\Http\Resources\ForumResource;
use App\Models\Forums;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    use Athorized;
    public function __construct()
    {
        return auth()->shouldUse('api');
    }

    public function index()
    {
        $user = $this->authorized();
        return ForumResource::collection(Forums::with('user:id,username', 'forumsComments')->get());
    }

    public function filter($category)
    {
        $this->authorized();
        return ForumResource::collection(
            Forums::with('user:id,username', 'forumsComments')
                ->where('category', $category)->get());
    }

    public function store(Request $request)
    {

        $this->valid($request->all());
        $user = $this->authorized();

        $user->forums()->create([
            'title' => request('title'),
            'body' => request('body'),
            'category' => request('category'),
            'slug' => Str::slug(request('title'), '-') . '-' . time(),
        ]);

        return response()->json([
            'message' => 'berhasil',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $this->valid($request->all());

        $forum = Forums::find($id);

        $this->getOwnerShip($forum->user_id);

        $forum->update([
            'title' => request('title'),
            'body' => request('body'),
            'category' => request('category'),
            'slug' => Str::slug(request('title'), '-') . '-' . time(),
        ]);

        return response()->json([
            'message' => 'berhasil update data',
        ]);

    }

    public function destroy($id)
    {
        $forum = Forums::find($id);
        $this->getOwnerShip($forum->user_id);
        $forum->delete();
        return response()->json(['message' => 'berhasil menghapus data'], 200);
    }

    private function valid($request)
    {
        $validator = Validator::make($request, [
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
        ]);
        if ($validator->fails()) {
            response()->json($validator->errors())->send();
            exit;
        }
    }
}