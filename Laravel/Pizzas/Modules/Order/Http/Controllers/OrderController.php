<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Order;
use Modules\Menu\Entities\Menu;
use Modules\Invoice\Entities\Invoice;
use Modules\Order\Http\Requests\StoreMenu;
use Modules\Order\Http\Requests\UpdateMenu;

class OrderController extends Controller
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
        $orders = Order::whereNotIn('status', ['completed', 'cancelled'])->get();
        try {
            foreach ($orders as $order) {
                $invoice = Invoice::find($order->invoice_id);
                $order->amount = $invoice->total_amount;
            }
        } catch (\Exception $error) {
            report($error);
        }
        
        return view('order::index', ["orders" => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data = Menu::all();
        $menu = [];
        try {
            foreach ($data as $row) {
                if (array_key_exists($row['category'], $menu)) {
                    $menu[$row['category']][] = $row;
                } else {
                    $menu[$row['category']] = [$row];
                }
            }
        } catch (\Exception $error) {
            report($error);
        }
        return view('order::create', ['menu' => $menu]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreOrder $request
     * @return Redirect '/invoice/create/{order_id}'
     */
    public function store(StoreOrder $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validated();
            $order_items = [];
    
            if ($request->has('ids')) {
                foreach ($validatedData['ids'] as $id) {
                    $item = Menu::findOrFail($id);
                    try {
                        $order_items[] = ["name" => $item->item, "quantity" => $validatedData[str_replace(" ", "", $item->item)]];
                    } catch (\Exception $error) {
                        report($error);
                    }
                }
            }
    
            $order = new Order();
            $order->item_details = json_encode($order_items);
            $order->save();
    
            return redirect()->route('create_invoice', ['order_id' => $order->id]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $invoice = Invoice::findOrFail($order->invoice_id);
        
        return view('order::edit', ["order" => $order, "invoice" => $invoice]);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateOrder $request
     * @param int $id
     * @return Redirect '/invoice/update/{order_id}'
     */
    public function update(UpdateOrder $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($request->isMethod('get')) {
            try {
                $order->status = "completed";
            } catch (\Exception $error) {
                report($error);
            }
        } else if ($request->isMethod('post')) {
            $validatedData = $request->validated();
            try {
                $item_details = json_decode($order->item_details);
    
                foreach ($item_details as $item) {
                    $item->quantity = $validatedData['quantity'][str_replace(' ', '', $item->name)];
                }
            } catch (\Exception $error) {
                report($error);
            }

            if ($request->has('deleted_items')) {
                try {
                    foreach ($item_details as $s_n => $item) {
                        if (array_key_exists(str_replace(' ', '', $item->name), $validatedData['deleted_items'])) {
                            unset($item_details[$s_n]);
                        }
                    }
                } catch (\Exception $error) {
                    report($error);
                }
            }

            $order->item_details = $item_details;
        }
        $order->save();

        return redirect()->route('update_invoice', ['order_id' => $order->id]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Redirect
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        try {
            $order->status = "canceled";
            $order->save();
        } catch (\Exception $error) {
            report($error);
        }

        return redirect()->route('index_order');
    }
}
