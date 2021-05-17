<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\ExchangeRate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreExchangeRateRequest;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all exchange rate
        $exchangeRates = ExchangeRate::getExchangeRates();
        if(!$exchangeRates->data){
            return back()->with('error', $exchangeRates->messange);
        }
        $exchangeRates = $exchangeRates->data;
        return view('dashboard/exchange_rate/index', compact('exchangeRates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view exchange rate add
        try{
            return view('dashboard/exchange_rate/add');
        }catch(Exception $e){
            return back()->with('error', 'Exchange rate view add not found!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreExchangeRateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExchangeRateRequest $request)
    {
        // request data from form
        $currecyCode  = $request['currency-code'];
        $currecyName  = $request['currency-name'];
        $exRate       = $request['exrate'];
        $symbol       = $request['symbol'];

       // check validation
        $checkValidateRequest = ExchangeRate::checkValidateRequests($currecyCode, $currecyName, $exRate, $symbol);
        if ($checkValidateRequest) {
            return back()->with('error', $checkValidateRequest->message);
        }

        try {
            DB::beginTransaction();
            // create exchange rate
            $exchange = new ExchangeRate([
                'currency_code'  => $currecyCode,
                'currency_name'  => $currecyName,
                'exchange_rate'  => $exRate,
                'symbol'         => $symbol,
            ]);
            
            // save to db
            $exchange->save();   

        } catch(QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[2];
            if($errorCode == "Duplicate entry '$currecyCode' for key 'exchange_rates_currency_code_unique'"){
                return back()->with('error', 'Currency code already exist!');
            }elseif($errorCode == "Duplicate entry '$currecyName' for key 'exchange_rates_currency_name_unique'"){
                return back()->with('error', 'Currency name already exist!');
            }
        }

        DB::commit();
        return redirect()->route('exrate-list')
        ->with('success', 'Exchange rate create successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         // find exchange rate record
         $exchangeRate = ExchangeRate::getExchangeRate($id);
         if(!$exchangeRate->data){
             return back()->with('error', $exchangeRate->messange);
         }
         $exchangeRate = $exchangeRate->data;
         return view('dashboard/exchange_rate/detail', compact('exchangeRate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         // find exchange rate record
         $exchangeRate = ExchangeRate::getExchangeRate($id);
         if(!$exchangeRate->data){
             return back()->with('error', $exchangeRate->messange);
         }
         $exchangeRate = $exchangeRate->data;
         return view('dashboard/exchange_rate/edit', compact('exchangeRate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\StoreExchangeRateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreExchangeRateRequest $request, $id)
    {
        
        // request data from form
        $currecyCode  = $request['currency-code'];
        $currecyName  = $request['currency-name'];
        $exRate       = $request['exrate'];
        $symbol       = $request['symbol'];

       // check validation
        $checkValidateRequest = ExchangeRate::checkValidateRequests($currecyCode, $currecyName, $exRate, $symbol);
        if ($checkValidateRequest) {
            return back()->with('error', $checkValidateRequest->message);
        }

         // find exchange rate record
         $exchangeRate = ExchangeRate::getExchangeRate($id);
         if(!$exchangeRate->data){
             return back()->with('error', $exchangeRate->messange);
         }
         $exchangeRate = $exchangeRate->data;

         try{
            DB::beginTransaction();
            
            // patch data
            $exchangeRate->currency_code  = $currecyCode;
            $exchangeRate->currency_name  = $currecyName;
            $exchangeRate->exchange_rate  = $exRate;
            $exchangeRate->symbol         = $symbol;      

            // update record
            $exchangeRate->save();
        } catch(QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[2];
            if($errorCode == "Duplicate entry '$currecyCode' for key 'exchange_rates_currency_code_unique'"){
                return back()->with('error', 'Currency code already exist!');
            }elseif($errorCode == "Duplicate entry '$currecyName' for key 'exchange_rates_currency_name_unique'"){
                return back()->with('error', 'Currency name already exist!');
            }
        }

        DB::commit();
        return redirect()->route('exrate-list')
            ->with('success', 'Exchange rate update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // check exchange rate record
        $exchangeRate = ExchangeRate::getExchangeRate($id);
        if(!$exchangeRate->data){
            return back()->with('error', $exchangeRate->messange);
        }
        $exchangeRate = $exchangeRate->data;

        try {
            // delete exchange rate in db
            $exchangeRate->delete();

            return redirect()->route('exrate-list')
                ->with('success', 'Exchange rate delete successfully!');
                
        }catch(ModelNotFoundException $e) {
            return redirect()->route('exrate-list')
                ->with('error', 'Exchange rate record not found!');
        }
    }
}
