<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{

    private function getModel()
    {
        return app("App\Models\Comment");
    }

    public function index()
    {
        $items = $this->getModel()::all();
        return response()->json($items);
    }

    public function todoComments($id){
        $user = auth()->user();

        $todo = $user->todos()->without('timelogs')->findOrFail($id);

        $comments = Comment::where('todo_id',$todo->id)->latest()
            ->with(['user' => function ($query) {
                $query->select(['id','name','profile_photo_path']);
            }])->paginate(5);


        return $this->res('Todos/Comments',[
            'todo' => $todo,
            'comments' => $comments
        ]);

    }


    public function store(Request $request)
    {
        $this->getModel()::create($request->all());
        return response()->json([
            "message" => "Successfully added."
        ], 201);
    }

    public function create(Request $request, $todoId){
        $user = auth()->user();

        $todo = $user->todos()->findOrFail($todoId);

        Comment::create(array_merge($request->validate([
            'comment' => ['required', 'max:255']
        ]),[
            'todo_id' => $todo->id,
            'user_id' => $user->id,
        ]));

        return Redirect::route('todos.comments',$todoId);
    }

    public function update(Request $request, $id)
    {
        if ($this->getModel()::where('id', $id)->exists()) {
            $item = $this->getModel()::find($id);
            $item->update($request->request->all(), []);
            return response()->json([
                "message" => "Item Updated."
            ], 200);
        } else {
            return response()->json([
                "message" => "Item Not Found."
            ], 404);
        }
    }

    public function show($id)
    {
        if ($this->getModel()::where('id', $id)->exists()) {
            $model = $this->getModel()::find($id)->get();
            return response()->json($model, 200);
        } else {
            return response()->json([
                "message" => "Item Not Found."
            ], 404);
        }
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $comment = $user->comments()->findOrFail($id);
        $todoId = $comment->todo_id;
        $comment->delete();

        return Redirect::route('todos.comments',$todoId);
    }

}
