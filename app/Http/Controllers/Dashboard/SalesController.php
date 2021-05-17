<?php

namespace App\Http\Controllers\Dashboard;

use App\Sale;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\StoreSaleRequest;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all sales
        $sales = Sale::getSales();
        if (!$sales->data) {
            return redirect()->route('sale-list')
                ->with('error', $sales->message);
        } else {
            $sales = $sales->data;
            return view('dashboard/sales/index', compact('sales'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   // get all product
        $products = Sale::getProducts();
        if(!$products->data){
            return redirect()->route('sale-list')
            ->with('error', $products->message);
        }

        // get all customer 
        $customers = Sale::getCustomers();
        
        if (!$customers->data) {
            return redirect()->route('sale-list')
                ->with('error', $customers->message);
        } else {
            $customers = $customers->data;
            $products = $products->data;
            return view('dashboard/sales/add', compact('customers', 'products'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSaleRequest $request)
    {
        // check validation 
        $checkRequestValidation = Sale::checkRequestValidation(
            $request['reference-num'],
            $request['sale-status'],
            $request['payment-status'],
            $request['total'],
            $request['paid'],
            $request['customer_id'],
        );

        if ($checkRequestValidation) {
            return back()->with('error', $checkRequestValidation->message);
        }

        try {
            DB::beginTransaction();

            // create sale
            $sale = new Sale([
                'datetime' => $request['datetime'],
                'reference_num' => $request['reference-num'],
                'sale_status' => $request['sale-status'],
                'payment_status' => $request['payment-status'],
                'total' => $request['total'],
                'paid' => $request['paid'],
                'sale_note' => $request['sale-note'],
                'staff_note' => $request['staff-note'],
                'customer_id' => $request['customer_id'],
            ]);

            // save to db
            $sale->save();
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $message = 'Barcorde formate already exist!';
            } else {
                $message = 'There is problem when trying to create barcorde formate!';
            }
            return back()->with('error', $message);
        }

        DB::commit();
        return redirect()->route('sale-list')
            ->with('success', 'Sale create successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // check sale record
        $sale = Sale::getSale($id);
        if (!$sale->data) {
            return redirect()->route('slae-list')
                ->with('error', $sale->message);
        } else {
            $sale = $sale->data;
            return view('dashboard/sales/detail', compact('sale'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get customer record
        $customers = Sale::getCustomers();
        if (!$customers->data) {
            return redirect()->route('sale-list')
                ->with('error', $customers->message);
        }

        // get sale record

        $sale = Sale::getSale($id);
        if (!$sale->data) {
            return redirect()->route('sale-list')
                ->with('error', $sale->message);
        } else {
            $sale = $sale->data;
            $customers = $customers->data;
            return view('dashboard/sales/edit', compact('sale', 'customers'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\StoreSaleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSaleRequest $request, $id)
    {
        // check validation 

        $checkRequestValidation = Sale::checkRequestValidation(
            $request['reference-num'],
            $request['sale-status'],
            $request['payment-status'],
            $request['total'],
            $request['paid'],
            $request['customer_id'],
        );

        if ($checkRequestValidation) {
            return back()->with('error', $checkRequestValidation->message);
        }

        try {
            DB::beginTransaction();
            // check sale record
            $sale = Sale::getSale($id);
            $sale = $sale->data;
            // patch sale
            $sale->datetime = $request['datetime'];
            $sale->reference_num = $request['reference-num'];
            $sale->sale_status = $request['sale-status'];
            $sale->payment_status = $request['payment-status'];
            $sale->total = $request['total'];
            $sale->paid = $request['paid'];
            $sale->sale_note = $request['sale-note'];
            $sale->staff_note = $request['staff-note'];
            $sale->customer_id = $request['customer_id'];

            // save to db
            $sale->save();
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $message = 'Barcorde formate already exist!';
            } else {
                $message = 'There is problem when trying to create barcorde formate!';
            }
            return back()->with('error', $message);
        }

        DB::commit();
        return redirect()->route('sale-list')
            ->with('success', 'Sale update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // check sale record
        $sale = Sale::getSale($id);
        if (!$sale->data) {
            return redirect()->route('slae-list')
                ->with('error', $sale->message);
        } else {
            $sale = $sale->data;
            $sale->delete();
            return redirect()->route('sale-list')
                ->with('success', 'Sale delete successfully!');
        }
    }
}
