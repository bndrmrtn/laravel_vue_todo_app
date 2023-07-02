<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatuschangeController extends Controller
{

    private function getModel()
    {
        return app("App\Models\Statuschange");
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
