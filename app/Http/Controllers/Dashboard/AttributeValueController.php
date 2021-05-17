<?php

namespace App\Http\Controllers\Dashboard;

use App;
use App\Attribute;
use App\Http\Controllers\Controller;
use Error;
use ErrorException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeValueController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        DB::beginTransaction();

        try{
            $attributeId = (int) $request->input('attribute');
            $attribute = App\Attribute::findOrFail($attributeId);
        }catch(ModelNotFoundException $e){
            return back()->with('error', 'Attribute Not Found');
        }

        $inputs = array_map(function ($item){
            return new App\AttributeValue([
                'attribute_value' => $item,
            ]);
        }, $request->input('attributeValue'));

        try{
            $result = $attribute->attributeValues()->saveMany($inputs);
            if(!$result){
                throw new ErrorException('Unable to Save Attribute Values');
            }
        }catch(ErrorException | Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

        DB::commit();
        return back()->with('success', 'Attribute Added Successfully');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
