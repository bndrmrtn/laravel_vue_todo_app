<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{

    private function getModel()
    {
        return app("App\Models\Status");
    }

    public function index()
    {
        $items = $this->getModel()::all();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255'
        ]);
        $this->getModel()::create($validated);
        return response()->json([
            "message" => "Successfully added."
        ], 201);
    }

    public function update(Request $request, $id)
    {
        if ($this->getModel()::where('id', $id)->exists()) {


            $item = $this->getModel()::find($id);
            /*foreach ($request->request->all() as $key => $value){
                $item->$key = $value;
            }*/
            $item->update($request->request->all(), []);
            // print_r($item);
            /*$item = Status::find($id);
            $item->fill($request->all())->save();*/
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
            //DB::enableQueryLog();
            $model = $this->getModel()::where(["id"=>$id])->get()[0];
            //dd(DB::getQueryLog());
            return response()->json($model, 200);
        } else {
            return response()->json([
                "message" => "Item Not Found."
            ], 404);
        }
    }

    public function destroy($id)
    {
        if ($this->getModel()::where('id', $id)->exists()) {
            $this->getModel()::find($id)->delete();
            return response()->json([
                "message" => "Item Deleted."
            ], 200);
        } else {
            return response()->json([
                "message" => "Item Not Found."
            ], 404);
        }
    }

}
