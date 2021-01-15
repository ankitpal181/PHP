<?php

namespace Modules\Invoice\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Entities\Menu;
use Modules\Order\Entities\Order;
use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Http\Requests\StoreInvoice;
use Modules\Invoice\Http\Requests\UpdateInvoice;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('invoice::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($order_id)
    {
        $order = Order::findOrFail($order_id);

        return view('invoice::create', ['order' => $order]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreInvoice $request
     * @param int $order_id
     * @return Redirect '/order'
     */
    public function store(StoreInvoice $request, $order_id)
    {
        $validatedData = $request->validated();
        $order = Order::findOrFail($order_id);
        $items = [];
        $order_amount = 0;
        $tax_rate = 18/100;
        $discount_rate = 0/100;
        try {
            foreach (json_decode($order->item_details) as $item) {
                $price = Menu::where('item', $item->name)->first()->price;
    
                $items[] = [
                    "name" => $item->name,
                    "price" => $price,
                    "quantity" => $item->quantity,
                    "amount" => $price * $item->quantity
                ];
                $order_amount += $price * $item->quantity;
            }
        } catch (\Exception $error) {
            report($error);
        }

        $invoice = new Invoice();
        $invoice->user_id = $request->user()->id;
        $invoice->item_amount = json_encode($items);
        $invoice->order_amount = $order_amount;
        $invoice->tax = $tax_rate * $order_amount;
        $invoice->discount = $discount_rate * $order_amount;
        $invoice->total_amount = $order_amount - $invoice->discount + $invoice->tax;
        $invoice->mode_of_payment = $validatedData['mode_of_payment'] + " " + $validatedData['payment_method'];
        $invoice->save();

        try {
            $order->invoice_id = $invoice->id;
            $order->customer_name = $validatedData['customer_name'];
            $order->customer_number = $validatedData['customer_number'];
            $order->order_type = $validatedData['order_type'];
            $order->status = "placed";
            $order->save();
        } catch (\Exception $error) {
            report($error);
        }

        // Code to trigger sms service for order placed to the user
        // Code to trigger generate invoice service

        return redirect()->route('index_order');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('invoice::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('invoice::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateInvoice $request
     * @param int $order_id
     * @return Redirect '/order'
     */
    public function update(UpdateInvoice $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $items = [];
        $order_amount = 0;
        $tax_rate = 18/100;
        $discount_rate = 0/100;

        try {
            foreach (json_decode($order->item_details) as $item) {
                $price = Menu::where('item', $item->name)->first()->price;
    
                $items[] = [
                    "name" => $item->name,
                    "price" => $price,
                    "quantity" => $item->quantity,
                    "amount" => $price * $item->quantity
                ];
                $order_amount += $price * $item->quantity;
            }

            $invoice = Invoice::findOrFail($order->invoice_id);
            $invoice->item_amount = json_encode($items);
            $invoice->order_amount = $order_amount;
            $invoice->tax = $tax_rate * $order_amount;
            $invoice->discount = $discount_rate * $order_amount;
            $invoice->total_amount = $order_amount - $invoice->discount + $invoice->tax;
            $invoice->save();
        } catch (\Exception $error) {
            report($error);
        }

        // Code to trigger sms service for order changed to the user
        // Code to trigger generate invoice service

        return redirect()->route('index_order');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
