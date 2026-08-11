<?php

namespace App\Services\OrderProduct;

use App\Models\Order;
use App\Models\OrderProduct;

class CreateOrderProductService
{
    public function handle(Order $order, array $attributes): OrderProduct
    {
        $orderProduct = new OrderProduct($attributes);
        $orderProduct->order_id = $order->id;

        $orderProduct->save();

        return $orderProduct;
    }
}