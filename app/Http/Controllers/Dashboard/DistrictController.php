<?php

namespace App\Http\Controllers\Dashboard;

use App\District;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $districts = District::with('sangkats')->paginate(10);
        return view('dashboard.district.index')->with('districts', $districts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.district.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'names'   => ['required', 'array'],
            'names.*' => ['required', 'string', 'max:255', 'distinct', 'unique:districts,district_name'],
        ]);

        $names = $request->input('names');

        DB::beginTransaction();

        foreach ($names as $name) {
            try {
                $district = District::create([
                    'district_name' => $name
                ]);
            } catch (QueryException $e) {
                return back()->with('error', 'Something went wrong while trying to create district');
            }
        }

        DB::commit();
        return back()->with('success', 'Districts Added Successfully');
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
        try {
            $district = District::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }

        return view('dashboard.district.edit')
            ->with('district', $district)
            ->with('sangkats', $district->sangkats);
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
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:districts,district_name']
        ]);

        try {
            $district = District::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'District not found');
        }

        //update
        $name = $request->input('name');
        if ($name && $name != $district->district_name) {
            $district->district_name = $name;
        
            if (!$district->save()) {
                return back()->with('error', 'Unable to update district');
            }
        }

        return redirect('dashboard/districts')->with('success', 'District updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $district = District::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'District not found');
        }

        if($district->delete()){
            return back()->with('success', 'District deleted successfully');
        }

        return back()->with('error', 'Unable to delete district');
    }
}
