<?php

namespace App\Http\Controllers;

use App\user;
use App\Order;
use App\District;
use App\Invoice;
use App\ShippingAddress;
use App\ShippingDetail;
use App\ProductVariant;
use Illuminate\Http\Request;
use App\CustomCart\CustomCart as Cart;
use App\Sangkat;
use ErrorException;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Throwable;

class CheckoutController extends Controller
{
    /**
     * Display a listing of cart items
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $productVariants = Cart::getProductVariantsWithAttrName();
        return view('checkout.index')->with('productVariants', $productVariants);
    }

    /**
     * Display the checkout form 
     * @param None
     * @return Illuminate\Http\Response 
     */
    public function create()
    {
        $productVariants = Cart::getProductVariantsWithAttrName();

        $user = auth()->user();

        $shippingAddresses = $customer = null;

        if ($user && $user->customer) {
            $customer          = ($user)     ? $user->getCustomerWithUserFields() : null;
            $shippingAddresses = ($customer) ? $customer->shippingAddresses       : null;
        }

        return view('checkout.contact')
            ->with('customer', $customer)
            ->with('districts', District::all())
            ->with('productVariants', $productVariants)
            ->with('shippingAddresses', $shippingAddresses);
    }

    /**
     * Process the checkout request
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response 
     */
    public function checkout(Request $request)
    {        
        $request->validate([
            'name'             => 'required|string',
            'note'             => 'nullable|string',
            'address'          => 'nullable|string',
            'email'            => 'nullable|email',
            'apartmentUnit'    => 'nullable|string',
            'payment-methods'  => 'required|string',
            'receiver-numbers' => 'nullable|string',
            'phone'            => 'required|numeric|digits_between:9,10',
            'sangkat'          => 'required|exists:sangkats,sangkat_id',
            'district'         => 'required|exists:districts,district_id',
        ]);

        // dd($request->all());

        // validate payment methods
        if(
            $request['payment-methods'] != 'aba' && 
            $request['payment-methods'] != 'pipay' && 
            $request['payment-methods'] != 'wing' && 
            $request['payment-methods'] != 'true-money' && 
            $request['payment-methods'] != 'cash-on-delivery'){
            return redirect()->back()->with('error', 'Invalid Payment Methods!');
        }

        DB::beginTransaction();

        try {
            //shipping address
            $shippingAddressInput = $request->input('shippingAddress');
            if ($shippingAddressInput) { //selected shippingAddress
                try {
                    $shippingAddress = ShippingAddress::findOrFail($shippingAddressInput);
                    $sangkat = $shippingAddress->sangkat;
                } catch (ModelNotFoundException $e) {
                    return back()->with('No Shipping Address Found');
                }
            } else { //entered a new shippingAddress
                try {
                    $sangkat = Sangkat::findOrFail($request->input('sangkat'));
                } catch (ModelNotFoundException $e) {
                    return back()->with('No Sangkat Found');
                }
                $customer = auth()->user();
                $shippingAddress = new ShippingAddress([
                    'note'           => $request->input('note'),
                    'address'        => $request->input('address'),
                    'apartment_unit' => $request->input('apartmentUnit'),
                    'sangkat_id'     => $sangkat  ? $sangkat->sangkat_id   : null,
                    'customer_id'    => $customer ? $customer->customer_id : null,
                ]);
            }

            //shipping detail
            $district = $sangkat->district;
            $address = ($shippingAddress->address) ? $shippingAddress->address : null;

            $shippingDetail = new ShippingDetail([
                'name'                => $request->input('name'),
                'email'               => $request->input('email'),
                'contact'             => $request->input('phone'),
                'note'                => $request->input('note'),
                'sangkat_name'        => $sangkat->sangkat_name,
                'apartment_unit'      => $request->input('apartmentUnit'),
                'district_name'       => $district ? $district->district_name : null,
                'address'             => $request->input('address') ?  $request->input('address') : $address,
                'receiver_numbers'    => $request->input('receiver-numbers'),
                'shipping_address_id' => $shippingAddress ? $shippingAddress->shipping_address_id : null,
            ]);

            //order
            $totalCost   = Cart::getTotalCost();
            $totalPrice  = Cart::getTotalPrice();
            $subTotal    = Cart::subtotal();

            $subTotal = str_replace(',','',$subTotal);
            
            $grandTotal  = $subTotal + $sangkat->delivery_fee;

            $order  = Order::create([
                'order_number'   => date('Ymd'),
                'payment_method' => $request['payment-methods'],
                'total_cost'     => $totalCost,
                'total_price'    => $totalPrice,
                'delivery_fee'   => $sangkat->delivery_fee,
                'grand_total'    => $grandTotal,
            ]);
            $order->update(['order_number' => $order->order_number . $order->order_id]);
            $order->shippingDetail()->save($shippingDetail);

            //order_details
            try {
                $orderDetails = Cart::generateOrderDetails();
            } catch (ErrorException $e) {
                return back()->with('error', $e->getMessage());
            }
            $order->orderDetails()->saveMany($orderDetails);
            //invoice
            $invoice = new Invoice([
                'total_cost'   => $totalCost,
                'total_price'  => $totalPrice,
                'delivery_fee' => $sangkat->delivery_fee,
                'grand_total'  => $grandTotal,
            ]);
            $order->invoice()->save($invoice);
        } catch (QueryException $e) {
            return back()->with('error', $e->getMessage());
        }

        DB::commit();
        Cart::destroy();
        // return view('checkout.invoice')
        return view('checkout.confirm-preview')->with('order', $order);
    }

    /**
     * Redirect to invoice after submit confirm
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response 
     */
    public function checkoutInvoice(Request $request) {
        try {
            $order = Order::find($request['order-id']);
            $orderDetails = $order->orderDetails;
            $shippingDetail = $order->shippingDetail;
        } catch (ModelNotFoundException | Throwable $e) {
            return back()->with('error', "Order not found!");
        }

        return view('checkout.invoice')
            ->with('order', $order)
            ->with('orderDetails', $orderDetails)
            ->with('shippingDetail', $shippingDetail);
    }
}