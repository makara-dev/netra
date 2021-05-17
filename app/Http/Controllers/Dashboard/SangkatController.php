<?php

namespace App\Http\Controllers\Dashboard;

use App\District;
use App\Http\Controllers\Controller;
use App\Sangkat;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SangkatController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sangkats = Sangkat::with('district')->orderBy('district_id')->paginate(10);
        return view('dashboard.sangkat.index')->with('sangkats', $sangkats);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = District::all();
        return view('dashboard.sangkat.create')->with('districts', $districts);
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
            'names'    => ['required', 'array'],
            'district' => ['required', 'exists:districts,district_id'],
            'names.*'  => ['required', 'string', 'max:255', 'distinct', 'unique:districts,district_name'],
        ]);

        $districtId = $request->input('district');
        try {
            $district = District::findOrFail($districtId);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'District not found');
        }

        DB::beginTransaction();

        $names = $request->input('names');
        $fees   = $request->input('deliveryFees');
        foreach ($names as $key => $name) {
            try {
                $sangkat = new Sangkat([
                    'sangkat_name' => $name,
                    'delivery_fee' => $fees[$key]
                ]);
                $district->sangkats()->save($sangkat);
            } catch (QueryException $e) {
                return back()->with('error', 'Something went wrong while trying to create sangkat');
            }
        }

        DB::commit();
        return back()->with('success', 'Sangkats Added Successfully');
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
            $sangkat = Sangkat::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }

        return view('dashboard.sangkat.edit')->with('sangkat', $sangkat);
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
            'name'        => ['required', 'string', 'max:255'],
            'deliveryFee' => ['required', 'numeric', 'min:0']
        ]);

        try {
            $sangkat = Sangkat::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Sangkat not found');
        }

        //update
        $name = $request->input('name');
        $deliveryFee = $request->input('deliveryFee');
        
        if ($name && $name != $sangkat->sangkat_name) {
            $sangkat->sangkat_name = $name;
        }
        if ($deliveryFee && $deliveryFee != $sangkat->delivery_fee) {
            $sangkat->delivery_fee = $deliveryFee;        
        }
        
        if (!$sangkat->save()) {
            return back()->with('error', 'Unable to update Sangkat');
        }
        return redirect('dashboard/sangkats')->with('success', 'Sangkat updated successfully');
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
            $sangkat = Sangkat::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Sangkat not found');
        }

        if ($sangkat->delete()) {
            return back()->with('success', 'Sangkat deleted successfully');
        }

        return back()->with('error', 'Unable to delete sangkat');
    }
}
