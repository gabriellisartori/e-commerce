<?php

namespace App\Services\OrderProductAdditional;

use App\Models\OrderProduct;
use App\Models\OrderProductAdditional;

class CreateOrderProductAdditionalService
{
    public function handle(OrderProduct $orderProduct, array $attributes): OrderProductAdditional
    {
        $orderProductAdditional = new OrderProductAdditional($attributes);
        $orderProductAdditional->order_product_id = $orderProduct->id;

        $orderProductAdditional->save();

        return $orderProductAdditional;
    }
}