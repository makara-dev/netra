<?php

namespace App\Http\Controllers\Dashboard;

use App;
use App\Attribute;
use App\Category;
use App\Http\Controllers\Controller;
use Error;
use ErrorException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.attribute.add')
        ->with('attributes', Attribute::all())
        ->with('categories', Category::all());
    }

    //
    public function store(Request $request)
    {
        //get category
        $categoryId = $request->input('category');
        try{
            $category = App\Category::findOrFail($categoryId);
        }catch(ModelNotFoundException $e){
            return back()->with('error', 'Please select a category first');
        }

        //insert attribute
        $name = $request->input('attribute');
        try {
            $attribute = new Attribute(['attribute_name' => $name]);  
            $result = $category->attributes()->save($attribute);
            
        } catch (Exception $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode === 1062) {
                return back()->with('error', 'Duplicate attribute name entry');
            } elseif ($errorCode === 1048) {
                return back()->with('error', 'Missing input for attribute');
            } else {
                return back()->with('error', 'Something went wrong');
            }
        }

        if(!$result){
            return back()->with('error', 'Unable to save to database');
        }
        
        return back()->with('success', 'Attribute added successfully');
    }
}
