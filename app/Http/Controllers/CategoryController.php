<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCategories = category::all();
        Session::get('isDhivehi') ? $lang = "dhi" : $lang = "eng";
        return view("$lang.category",['allCategories' => $allCategories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchcate(Request $request)
    {
        $searchCate = category::where('cate_name', 'LIKE', "%$request->s%")->get();
        return  json_decode($searchCate, true); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'cate_name' => ['required', 'string'],
            'unit_price' => ['required'],
            // 'img' => ['required']
        ]);;
        $newPath = "default.png";
        if(request('img')){
            $newPath = time() . "_" . request('cate_name') . "." . request('img')->extension();   
            request('img')->move(public_path("img"), $newPath);
        }
        
        $newCategory = new category ([
            'cate_name' => request('cate_name'),
            'unit_price' => request('unit_price'),
            'img_path' => $newPath
        ]);
        $newCategory->save();
        return redirect('/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
    }
}
