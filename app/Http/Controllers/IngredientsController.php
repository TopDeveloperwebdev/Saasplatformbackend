<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingredient;
use Auth;
use Illuminate\Support\Facades\DB;

class IngredientsController extends Controller
{
    /**
     * Display a listing of the Ingredient.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $instance_id = $data['instance_id'];
        if ($instance_id == 0) {
            $res = DB::select("SELECT * from `ingredients` order by id DESC ");
        } else {

            $res = DB::select("SELECT * from `ingredients` where instance_id like $instance_id  order by id DESC ");
        }

        return $res;
    }

    /**
     * Show the form for creating a new Ingredient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Ingredient::pluck('title', 'id');
        return view('admin.Ingredient.create', compact('categories'));
    }

    /**
     * Store a newly created Ingredient in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        return Ingredient::create($data);
    }


    /**
     * Update the specified Ingredient in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();

        return Ingredient::whereId($request->get('id'))->update($data);
    }

    /**
     * Remove the specified Ingredient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $res = Ingredient::where('id', $request->get('id'))->delete();
        return $res;
    }
}
