<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\CustomerGroup;
use App\Customer;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreCustomerGroupRequest;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        // get all customer group
        $customerGroups = CustomerGroup::getCustomerGroups();
        if(!$customerGroups->data){
            return back()->with('error', $customerGroups->messange);
        }
        $customerGroups = $customerGroups->data;
        return view('dashboard/customer_group/index', compact('customerGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get all customer record
        $customers = CustomerGroup::getCustomers();
        if(!$customers->data){
            return back()->with('error', $customers->messange);
        }
        $customers = $customers->data;
        return view('dashboard/customer_group/add', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerGroupRequest $request)
    {
        // request data from form
        $name = $request['name'];
        $discount = $request['discount'];
        $customers = $request['cus-id'];
        
        // check validation
        $checkValidateRequest = CustomerGroup::checkValidateRequest($name, $discount, $customers);
        if ($checkValidateRequest) {
            return back()->with('error', $checkValidateRequest->message);
        }
     
        try {
            DB::beginTransaction();
            // create customer group
            $customerGroup = new CustomerGroup([
                'name'      => $name,
                'discount'  => $discount,
            ]);
            // save to db
            $customerGroup->save(); 
            $lastId = $customerGroup->id;
            if($customers != null ){
                foreach($customers as $item){
                    $cus = Customer::find($item);
                    $cus->customer_group_id = $lastId;
                    $cus->save();
                }
            }

        } catch(QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                return back()->with('error', 'Customer group name already exist!');
            }
        }

        DB::commit();
        return redirect()->route('cusgroup-list')
        ->with('success', 'Customer group create successfully!');
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // find customer group record
        $customerGroup = CustomerGroup::getCustomerGroup($id);
        if(!$customerGroup->data){
            return back()->with('error', $customerGroup->messange);
        }
        $customerGroup = $customerGroup->data;
        return view('dashboard/customer_group/detail', compact('customerGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get all customer record
        $customers = CustomerGroup::getCustomers();
        if(!$customers->data){
            return back()->with('error', $customers->messange);
        }
        $customers = $customers->data;

        // find customer group record
        $customerGroup = CustomerGroup::getCustomerGroup($id);
        if(!$customerGroup->data){
            return back()->with('error', $customerGroup->messange);
        }
        $customerGroup = $customerGroup->data;

        try {
            //return data into view
            return view('dashboard/customer_group/edit', compact('customerGroup', 'customers'));

        } catch(ModelNotFoundException $e) {
            return redirect()->route('cusgroup-list')
                ->with('error', 'Customer group record not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCustomerGroupRequest $request, $id)
    {
         // request data from form
         $name = $request['name'];
         $discount = $request['discount'];
         $customers = $request['cus-id'];

         // check validation
         $checkValidateRequest = CustomerGroup::checkValidateRequest($name, $discount, $customers);
         if ($checkValidateRequest) {
             return back()->with('error', $checkValidateRequest->message);
         }

        // find customer group record
        $customerGroup = CustomerGroup::getCustomerGroup($id);
        if(!$customerGroup->data){
            return back()->with('error', $customerGroup->messange);
        }
        $customerGroup = $customerGroup->data;

        try{
            DB::beginTransaction();
            
            // patch data
            $customerGroup->name      = $name;
            $customerGroup->discount  = $discount;

            // update record
            $customerGroup->save();

            // update customer
            foreach ($customerGroup->customers as $item){
                $item->customer_group_id = null;
                $item->save();
            }
            if($customers != null ){
                foreach($customers as $item){
                    $cus = Customer::find($item);
                    $cus->customer_group_id = $id;
                    $cus->update();
                }
            }

        } catch(QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                return back()
                    ->with('error', 'Customer group name already exist!');
            }
        }

        DB::commit();
        return redirect()->route('cusgroup-list')
            ->with('success', 'Customer group update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // check customer group record
        $customerGroup = CustomerGroup::getCustomerGroup($id);
        if(!$customerGroup->data){
            return back()->with('error', $customerGroup->messange);
        }
        $customerGroup = $customerGroup->data;

        try {
            // delete custoner group in db
            $customerGroup->delete();

            return redirect()->route('cusgroup-list')
                ->with('success', 'Customer group delete successfully!');
                
        } catch(ModelNotFoundException $e) {
            return redirect()->route('cusgroup-list')
                ->with('error', 'Customer group record not found!');
        }
    }
}
