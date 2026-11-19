<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Task $task)
    {
        return CommentResource::collection($task->comments()->paginate(10));
    }

    public function store(StoreCommentRequest $request, Task $task)
    {
        $data = $request->validated();
        $data['task_id'] = $task->id;
        
        $comment = Comment::create($data);
        return new CommentResource($comment);
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate(['content' => 'required|string|max:1000']);
        $comment->update($validated);
        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->noContent();
    }
}