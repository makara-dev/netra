<?php

namespace App\Http\Controllers\Dashboard;

use App\ExchangeRate;
use App\Http\Controllers\Controller;

use App\Quotation;
use App\Sale;
use App\ProductVariant;
use Exception;
use Symfony\Component\HttpFoundation\Request;

use App\Http\Requests\Dashboard\StoreQuotationRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @var String $quotations get all quotation data
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::getQuotaions();
        if (!$quotations->data) {
            return redirect()->route('quotation-list')
                ->with('error', $quotations->message);
        }
        $quotations = $quotations->data;
        return view('dashboard/quotation/index', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     * @var String $customer get all customer data
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Quotation::getCustomer();
        if (!$customers->data) {
            return back()->with('error', $customers->message);
        }
        $customers = $customers->data;
        return view('dashboard/quotation/add', compact('customers'))
        ->with('productvars', ProductVariant::all())
        ->with('exchangerates', ExchangeRate::all());
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @var String $checkValidateRequest check request validation from model
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuotationRequest $request)
    {
        $checkValidateRequest = Quotation::checkValidateRequest(
            $request['reference_num'],
            $request['total'], 
            $request['customer_id'], 
            $request['status'],
            $request['exchange_rate']
        );
        if ($checkValidateRequest) {
            return back()->with('error', $checkValidateRequest->message);
        }
        
        try {
            DB::beginTransaction();
            $quotation = new Quotation([
                'staff_note'        => $request['staff_note'],
                'quotation_note'    => $request['quotation_note'],
                'total'             => $request['total'],
                'status'            => $request['status'],
                'reference_num'     => $request['reference_num'],
                'datetime'          => $request['datetime'],
                'customer_id'       => $request['customer_id'],
                'exchange_rate_id'  => $request['exchange_id']
            ]);


            $quotation->save();
            $productvar = $request['product_va_id'];
            $quotation->productvars()->attach($productvar);

        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $message = 'Reference number already exist!';
            } else {
                $message = 'There is problem when trying to create quotation!';
            }
            return back()->with('error', $message);
        }

        DB::commit();
        return redirect()->route('quotation-list')
            ->with('success', 'Quotation create successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @var String $quotation find quotation id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::getQuotation($id);
        if (!$quotation->data) {
            return back()->with('error', $quotation->message);
        }
        $quotation = $quotation->data;
        return view('dashboard/quotation/detail', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation = Quotation::getQuotation($id);
        if (!$quotation->data) {
            return back()->with('error', $quotation->message);
        }
        $quotation = $quotation->data;
        $customers = Quotation::getCustomer();
        if (!$customers->data) {
            return back()->with('error', $customers->message);
        }
        $customers = $customers->data;
        return view('dashboard/quotation/edit', compact('quotation', 'customers'))
        ->with('productvars', ProductVariant::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @var String $quotationResult check is quotation id found
     * @var String $checkValidateRequest check request validation from model
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuotationRequest $request, $id)
    {
        $checkValidateRequest = Quotation::checkValidateRequest(
            $request['reference_num'], 
            $request['total'], 
            $request['customer_id'], 
            $request['status']
        );
        if ($checkValidateRequest) {
            return back()->with('error', $checkValidateRequest->message);
        }

        $quotationResult = Quotation::getQuotation($id);
        if (!$quotationResult->data) {
            return back()->with('error', $quotationResult->message);
        }

        try {
            $quotationResult->data->quotation_note  = $request['quotation_note'];
            $quotationResult->data->staff_note      = $request['staff_note'];
            $quotationResult->data->total           = $request['total'];
            $quotationResult->data->status          = $request['status'];
            $quotationResult->data->reference_num   = $request['reference_num'];
            $quotationResult->data->datetime        = $request['datetime'];
            $quotationResult->data->customer_id     = $request['customer_id'];
            $quotationResult->data->save();
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $message = 'Reference number already exist';
            } else {
                $message = 'There is problem when trying to create reference number formate!';
            }
            return back()->with('error', $message);
        }
        DB::commit();
        return redirect()->route('quotation-list')
            ->with('success', 'Quotation update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @var String $quotation check is id found
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quotation = Quotation::getQuotation($id);
        if (!$quotation->data) {
            return back()->with('error', $quotation->message);
        }
        try {
            $quotation->data->delete();
        } catch (Exception $e) {
            return redirect()->route('quotation-list')
                ->with('error', 'Quotation record not found!');
        }
        DB::commit();
        return redirect()->route('quotation-list')
            ->with('success', 'Quotation delete successfully!');
    }


    /**
     * Create Quotation to sale
     * @param  int  $id
     * @var String $quotation check is id found
     * @return \Illuminate\Http\Response
     */
    public function createToSale($id)
    {
        $quotation = Quotation::getQuotation($id);
        if (!$quotation->data) {
            return back()->with('error', $quotation->message);
        }
        try {
            DB::beginTransaction();
            $sale = new Sale([
                'datetime'          => $quotation->data->datetime,
                'reference_num'     => $quotation->data->reference_num,
                'sale_status'       => 'Completed',
                'payment_status'    => '',
                'total'             => $quotation->data->total,
                'paid'              => 0.00,
                'sale_note'         => $quotation->data->quotation_note,
                'staff_note'        => $quotation->data->staff_note,
                'customer_id'       => $quotation->data->customer_id,
            ]);
            $sale->save();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('quotation-list')
                ->with('error', 'Reference number should not be duplicate');
        }

        DB::commit();
        return redirect()->route('sale-list')
            ->with('success', 'Quotation create to sale successfully!');
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = ProductVariant::select("product_variant_sku")
                ->where("	product_variant_sku","LIKE","%{$request->query}%")
                ->get();
   
        return response()->json($data);
    }
}
