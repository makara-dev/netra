<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest as RequestsStoreOrderRequest;
use App\Order;
use App\ProductVariant;
use App\District;
use App\Sangkat;
use App\ExchangeRate;
use App\ShippingAddress;
use App\ShippingDetail;
use App\Http\StoreOrderRequest;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use App\CustomLibs\ArrayCompare;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{

    /**
     * Display a listing of order
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->query('order_status');

        $query = ($filter && $filter != 'all')
            ?
            Order::where('order_status', $filter)->with('shippingDetail')
            :
            Order::with('shippingDetail');

        $orders = $query->latest()->paginate(10);

        $deliveryStatuses = [
            'btn-outline-danger'  => 'cancel',
            'btn-outline-warning' => 'pending',
            'btn-outline-info'    => 'delivering',
            'btn-outline-success' => 'delivered',
        ];

        $paymentStatuses  = [
            'btn-outline-danger'  => 'cancel',
            'btn-outline-warning' => 'pending',
            'btn-outline-info'    => 'partial',
            'btn-outline-success' => 'paid',
        ];

        return view('dashboard.order.index')
            ->with('orders', $orders)
            ->with('deliveryStatuses', $deliveryStatuses)
            ->with('paymentStatuses', $paymentStatuses)
            ->with('filter', $filter ? $filter : 'All orders');
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $order = Order::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Order not found');
        }
        return view('dashboard.order.detail')
            ->with('order', $order)
            ->with('orderDetails',  $order->orderDetails)
            ->with('shippingDetail', $order->shippingDetail);
    }

    /**
     * Create the order
     */
    public function create()
    {
        $customers = Order::getCustomers();
        if (!$customers->data) {
            return back()->with('error', $customers->message);
        }
        $user = auth()->user();

        $shippingAddresses = $customer = null;

        if ($user && $user->customer) {
            $customer          = ($user)     ? $user->getCustomerWithUserFields() : null;
            $shippingAddresses = ($customer) ? $customer->shippingAddresses       : null;
        }
        $customers = $customers->data;
        $productv = ProductVariant::all();
        if (count($productv) < 1) {
            return back()->with('error', 'Please add product before add order!');
        }
        return view('dashboard/order/add', compact('customers'))
            ->with('customer', $customer)
            ->with('productvars', ProductVariant::all())
            ->with('districts', District::all())
            ->with('exchangerates', ExchangeRate::all())
            ->with('shippingAddresses', $shippingAddresses);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @var String $checkValidateRequest check request validation from model
     * @return \Illuminate\Http\Response
     */
    public function store(RequestsStoreOrderRequest $request)
    {
        // dd($request['grands']);
        $productvar = $request['productVariantRows'];
        $checkValidateRequest = Order::checkValidateRequest(
            $request['reference_num'],
            $request['customer_id'],
            $request['order_status'],
            $request['product_va_id'],
            $request['totalCost'],
            $request['totalPrice'],
            $request['delivery_fee'],
            $request['grandTotal'],
            $request['sale_tax'],
            $request['payment_status'],
            $request['delivery_status'],
            $request['payment_method'],
            $request['exchange_id'],
        );

        if ($checkValidateRequest) {
            return back()->with('error', $checkValidateRequest->message);
        }

        $order_number = $request['reference_num'];
        $payment_method = 'cash on delivery';
        $total_cost = $request['totalCost'];
        $total_price = $request['totalPrice'];
        $delivery_fee = $request['delivery_fee'];
        $grand_total = $request['grandTotal'];
        $sale_tax = $request['sale_tax'];
        $sale_type = 'Shop';
        $order_status = $request['order_status'];
        $payment_status = $request['payment_status'];
        $delivery_status = $request['delivery_status'];
        $customers_id = $request['customer_id'];
        $payment_method = $request['payment_method'];
        $exchange_id = $request['exchange_id'];
        // dd($exchange_id);
        // $exchange_rate = $request['exchange_rate'];

        try {
            DB::beginTransaction();
            $order = new Order([
                'order_number' => $order_number,
                'payment_method' => $payment_method,
                'total_cost' => $total_cost,
                'total_price' =>  $total_price,
                'delivery_fee' => $delivery_fee,
                'grand_total' => $grand_total + $delivery_fee,
                'sale_tax' => $sale_tax,
                'sale_type' => $sale_type,
                'order_status' => $order_status,
                'payment_status' => $payment_status,
                'delivery_status' => $delivery_status,
                'customer_id' => $customers_id,
                'exchange_rate_id' => $exchange_id,
                // 'promotion_id' => $promotion_id,
            ]);

            $order->save();
            $productvar = $request['productVariantRows'];
            $order->product_variants()->attach($productvar);

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
            $order_id = DB::table('orders')->latest('order_id')->first();
            // dd($order_id);
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
                'order_id'    => $request->input('$order_id'),
                'shipping_address_id' => $shippingAddress ? $shippingAddress->shipping_address_id : null,
            ]);

            $order->shippingDetail()->save($shippingDetail);
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $message = 'Reference number already exist!';
            } else {
                dd($e);
                $message = 'There is problem when trying to create order!';
            }
            return back()->with('error', $message);
        }

        DB::commit();
        return redirect()->route('order-list')
            ->with('success', 'Order create successfully!');
    }

    /**
     * Display the order editing form
     * 
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $order = Order::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Order not found');
        }

        return view('dashboard.order.detail')
            ->with('order', $order)
            ->with('orderDetails',  $order->orderDetails)
            ->with('shippingDetail', $order->shippingDetail);
    }

    /**
     * update the specified order
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $orderStatus    = $request->input('orderStatus');
        $paymentStatus  = $request->input('paymentStatus');
        $deliveryStatus = $request->input('deliveryStatus');

        try {
            DB::beginTransaction();
            $order = Order::findOrFail($request->input('id'));

            // update stock adjustment base on confirmed status delivery and payment
            if ($orderStatus == 'confirmed' && $deliveryStatus == 'delivered' && $paymentStatus == 'paid') {
                //sync items'stock with order on confirmed
                $errors = $order->syncStock();
                if (count($errors)) {
                    return back()->withErrors($errors);
                }

                // if item is available
                $orderDetails = $order->orderDetails;
                foreach ($orderDetails as $orderDetail) {
                    $productVariant = $orderDetail->productVariant;
                    $productVariant->quantity -= $orderDetail->quantity;
                    $productVariant->update();
                }

                // change order status to confirmed
                $order->order_status = $orderStatus;
            } elseif ($orderStatus == 'cancelled') {
                $order->markAsCancelled();
            } elseif ($orderStatus == 'completed') {
                $order->markAsCompleted();
            } else { //update other statuses normally
                if ($paymentStatus  && $paymentStatus  != $order->payment_status) {
                    $order->payment_status = $paymentStatus;
                }
                if ($deliveryStatus && $deliveryStatus != $order->deliveryStatus) {
                    $order->delivery_status = $deliveryStatus;
                }
                if ($orderStatus    && $orderStatus    != $order->order_status) {
                    $order->order_status = $orderStatus;
                }
            }

            // save order
            $order->save();
        } catch (Throwable | ModelNotFoundException | Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Order not found');
        }
        DB::commit();
        return back()->with('success', 'Order #' . $order->order_number . ' updated successfully');
    }
    /**
     * Delete the specified order.
     * 
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
        } catch (Throwable | Exception $e) {
            return redirect('dashboard/invoice')->with('error', 'Unable to find Order!');
        }
        return back()->with('success', 'Order deleted successfully');
    }

    /**
     * Generate order pdf and download to user browser.
     * @param Request $request
     */
    public function pdf(Request $request, bool $download = true)
    {
        try {
            $order = Order::findOrFail($request->input('orderId'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'No order found');
        }

        $view = view('checkout.pdf')
            ->with('order', $order)
            ->with('orderDetails',  $order->orderDetails)
            ->with('shippingDetail', $order->shippingDetail)
            ->render();

        // return $view;
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->render();

        return $dompdf->stream($order->order_number . '.pdf', array("Attachment" => $download));
    }
}
