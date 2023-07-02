<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Group;
use App\Models\Status;
use App\Models\Statuschange;
use App\Models\Timelog;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use PHPUnit\TextUI\XmlConfiguration\Groups;

class TodoController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getModel()
    {
        return app("App\Models\Todo");
    }

    public function getTodosForUser()
    {
        $userId = auth()->user()->id;

        $todos = Todo::without('timelogs')->where("user_id","=",$userId)->orderBy('id','DESC')->paginate(4);

        foreach($todos as $key => $todo){
            $todos[$key]['current_status'] = $todo->status->name;
            $todos[$key]['group_name'] = $todo->group->group;
            if(!$todo->finished) $todos[$key]['active'] = $todo->hasActiveActivity();
            else $todos[$key]['active'] = false;
        }

        //dd($todos);

        return $this->res('Todos/Todos', [
            'todos' => $todos,
        ]);

       //var_dump(auth()->id);
        //$userID = auth()->user()->id;

        //
        //return response()->json("asdf");
    }

    public function dashboard(){
        $user = auth()->user();

        $active_todos = $user->todos()
            ->where('finished','=',0)
            ->withCount('timelog')
            ->having('timelog_count', '>', 0)
            ->latest()
            ->limit(5)
            ->get();
        $date = now()->subDays(30);

        $timelogs = $user->timelogs()
            ->selectRaw('CAST(created_at AS DATE) as create_date,
            SUM(TIMESTAMPDIFF(SECOND ,created_at,updated_at)) as seconds_on_day')
            ->where('created_at','>',$date)
            ->groupBy('create_date')->get(15);

        foreach ($timelogs as $key => $log){
            $timelogs[$key]['create_date'] = Carbon::parse($timelogs[$key]['create_date'])->format('m-d');
        }

        $groups = [];
        $todos = $user->todos()->get();
        foreach($todos as $todo){
            if(!isset($groups[$todo->group->group])) $groups[$todo->group->group] = 0;
            $groups[$todo->group->group] += 1;
        }

        $priority = $user->todos()
            ->where('finished','=',0)
            ->withCount('timelog')
            ->having('timelog_count', '<=', 0)
            ->orderBy('priority','desc')
            ->limit(5)
            ->get();

        return $this->res('TodoDash',[
            'active_todos' => $active_todos,
            'daily_activity' => $timelogs,
            'group_count' => $groups,
            'highest_priority' => $priority,
        ]);

        /*
        SELECT CAST(created_at AS DATE) as create_date,
        SUM(TIMESTAMPDIFF(MINUTE ,created_at,updated_at)) as minutes_on_day
        FROM timelogs
        WHERE created_at > '2022-07-19' AND created_at < '2022-07-26'
        GROUP BY create_date;
         */
    }

    public function getTodoForm(){
        //dd(Status::get());
        return $this->res('Todos/Create', [
            'statuses' => Status::get(),
            'groups' => Group::get(),
        ]);
    }

    public function getEditForm($id){
        $todo = auth()->user()->todos()->findOrFail($id);
        return $this->res('Todos/Edit', [
            'statuses' => Status::get(),
            'groups' => Group::get(),
            'todo' => $todo,
        ]);
    }


    public function finish($id){
        $todo = auth()->user()->todos()->findOrFail($id);
        $todo->finished = 1;
        $todo->save();
        Timelog::where('todo_id', '=', $id)->update(['finished' => 1]);
        return Redirect::route('todos.view',$id);
    }


    public function storeTodo(TodoRequest $request){
        $userId = auth()->user()->id;

        Todo::create(
            array_merge($request->validated(),['user_id' => $userId])
        )->logStatus();

        return Redirect::route('todos');
    }

    public function changeActivity($id){
        $user = auth()->user();
        $todo = $user->todos()->findOrFail($id);
        $activity = $todo->hasActiveActivity();

        // \DB::enableQueryLog();
        $hasUnfinished = $user->todos()
            ->whereHas('timelog', function ($query) {
                return $query->where('finished', '=', 0);
            })->first();
        //dd($hasUnfinished);
        /*$sql = \DB::getQueryLog();
        dd($sql);*/

        if($activity){
            $activity->finished = 1;
            $activity->save();
        } else if($hasUnfinished) {
            return Redirect::route('todos.view',$id)->withErrors(['warn'=>'Finish your current activity to start a new!']);
        } else {
            $timelog = new Timelog();
            $timelog->todo_id = $todo->id;
            $timelog->user_id = $user->id;
            $timelog->save();
        }
        return Redirect::route('todos.view',$id);
    }

    public function index()
    {
        $items = $this->getModel()::all();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $this->getModel()::create($request->all());
        return response()->json([
            "message" => "Successfully added."
        ], 201);
    }

    public function update(TodoRequest $request, $id)
    {
        $data = $request->validated();

        $todo = auth()->user()->todos()->findOrFail($id);
        // $todo = $this->getModel()::find($id);
        if($todo->current_status_id != $data['current_status_id'])  $todo->logStatus($data['current_status_id']);
        $todo->update($data);
        return Redirect::route('todos.view',$id);
    }

    public function show($id)
    {
        $user = auth()->user();
        $todo = $user->todos()->findOrFail($id);

        /*\DB::connection()->enableQueryLog();
        Timelog::where('todo_id',$id)->get();
        $queries = \DB::getQueryLog();
        dd($queries);*/

        return $this->res('Todos/View', [
            'todo' => $todo,
            'active' => $todo->hasActiveActivity(),
            'timelogs' => Timelog::where('todo_id','=',$id)->get(),
        ]);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $todo = $user->todos()->findOrFail($id);
        Timelog::where('todo_id','=',$todo->id)->delete();
        Comment::where('todo_id','=',$todo->id)->delete();
        $todo->delete();
        return Redirect::route('todos');
    }

}
