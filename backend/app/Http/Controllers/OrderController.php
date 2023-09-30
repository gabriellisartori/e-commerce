<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\Order\CreateOrderService;
use App\Services\OrderProductAdditional\CreateOrderProductAdditionalService;
use App\Services\OrderProduct\CreateOrderProductService;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function __construct(
        private CreateOrderService $createOrderService,
        private CreateOrderProductService $createOrderProductService,
        private CreateOrderProductAdditionalService $createOrderProductAdditionalService
    ) {
    }

    public function index()
    {
        try {
            //get all orders
            $orders = Order::all()
                ->load([
                    'orderProduct',
                    'orderProduct.orderProductAdditional',
                    'orderProduct.product',
                    'orderProduct.product.productPromotion',
                    'orderProduct.product.productIngredient',
                    'orderProduct.product.productAdditional'
                ]);

            return response()->json(OrderResource::collection($orders), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar pedidos',
            ], 401);
        }
    }

    public function show(OrderRequest $request)
    {
        try {
            //get one order
            $data = $request->validated();

            $order = Order::findOrFail($data['id'])
                ->load([
                    'orderProduct',
                    'orderProduct.orderProductAdditional',
                    'orderProduct.product',
                    'orderProduct.product.productPromotion',
                    'orderProduct.product.productIngredient',
                    'orderProduct.product.productAdditional'
                ]);

            return response()->json(new OrderResource($order), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar pedido',
            ], 401);
        }
    }

    public function store(CreateOrderRequest $request)
    {
        try {
            $data = $request->validated();

            //create order
            $order = $this->createOrderService->handle($data);

            foreach ($data['order_product'] as $orderProduct) {
                //create order product
                $newOrderProduct = $this->createOrderProductService->handle($order, $orderProduct);

                if (! isset($orderProduct['order_product_additional'])) {
                    continue;
                }
                
                //create order product additional
                foreach ($orderProduct['order_product_additional'] as $orderProductAdditional) {
                    $this->createOrderProductAdditionalService->handle($newOrderProduct, $orderProductAdditional);
                }
            }

            $order->load([
                'orderProduct',
                'orderProduct.orderProductAdditional',
                'orderProduct.product',
                'orderProduct.product.productPromotion',
                'orderProduct.product.productIngredient',
                'orderProduct.product.productAdditional'
            ]);

            return response()->json(new OrderResource($order), 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao criar pedido',
            ], 401);
        }
    }

    public function update(UpdateOrderRequest $request)
    {
        try {
            $data = $request->validated();

            $order = Order::findOrFail($data['id']);

            //update order
            $order->update([
                'paid' => $data['paid']
            ]);

            $order->load([
                'orderProduct',
                'orderProduct.orderProductAdditional',
                'orderProduct.product',
                'orderProduct.product.productPromotion',
                'orderProduct.product.productIngredient',
                'orderProduct.product.productAdditional'
            ]);

            return response()->json(new OrderResource($order), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao atualizar pedido',
            ], 401);
        }
    }
}
