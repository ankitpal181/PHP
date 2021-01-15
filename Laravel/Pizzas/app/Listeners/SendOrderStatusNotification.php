<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;

class SendOrderStatusNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        // Send order status notification to the customer via email
        // $order_details = $event->order->latest->first();

        // $order_no = $order_details['id'];
        // $customer_name = $order_details['customer_name'];
        // $customer_email = $order_details['customer_email'];
        // $order_type = $order_details['order_type'];
        // $order_status = "Order Placed";

        Mail::send(new OrderPlaced());
    }
}
