<?php

namespace App\Http\Controllers\Api;

use App\District;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ApiDistrictController extends Controller
{
    //
    public function sangkats($id){
        try{
            $district = District::findOrFail($id);
            $sangkats = $district->sangkats;

            $response = [
                'status' => 'success',
                'message' => $sangkats,
            ];
        }catch(ModelNotFoundException $e){
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($response);
    }
}
