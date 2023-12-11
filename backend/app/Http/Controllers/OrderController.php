<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Mail\OrderMail;
use App\Models\Additional;
use App\Models\Client;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\ProductAdditional;
use App\Services\Order\CreateOrderService;
use App\Services\OrderProductAdditional\CreateOrderProductAdditionalService;
use App\Services\OrderProduct\CreateOrderProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function __construct(
        private CreateOrderService $createOrderService,
        private CreateOrderProductService $createOrderProductService,
        private CreateOrderProductAdditionalService $createOrderProductAdditionalService
    ) {
    }

    public function index(Request $request)
    {
        $inputs = $request->input();

        try {
            //get all orders
            $orders = Order::query()
                ->orderBy('created_at', 'desc')
                ->with([
                    'orderProduct',
                    'orderProduct.orderProductAdditional',
                    'orderProduct.product',
                    'orderProduct.product.productPromotion',
                    'orderProduct.product.productIngredient',
                    'orderProduct.product.productAdditional',
                    'client'
                ]);

            if (isset($inputs['start_date']) && isset($inputs['end_date'])) {
                $orders = $orders->whereBetween('created_at', [$inputs['start_date'], $inputs['end_date'] ]);
            } else if (isset($inputs['start_date'])) {
                $orders = $orders->where('created_at', '>=', $inputs['start_date']);
            } else if (isset($inputs['end_date'])) {
                $orders = $orders->where('created_at', '<=', $inputs['end_date']);
            }

            $orders = $orders->get();

            return response()->json(OrderResource::collection($orders), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar pedidos',
            ], 401);
        }
    }

    public function show($id)
    {
        try {
            //get one order
            $order = Order::findOrFail($id)
                ->load([
                    'orderProduct',
                    'orderProduct.orderProductAdditional',
                    'orderProduct.product',
                    'orderProduct.product.productPromotion',
                    'orderProduct.product.productIngredient',
                    'orderProduct.product.productAdditional',
                    'client'
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
        DB::beginTransaction();
        try {
            $data = $request->validated();

            //create order
            $order = $this->createOrderService->handle($data);

            foreach ($data['order_product'] as $orderProduct) {
                //create order product
                $newOrderProduct = $this->createOrderProductService->handle($order, $orderProduct);

                if (!isset($orderProduct['order_product_additional'])) {
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
                'orderProduct.product.productAdditional',
                'client'
            ]);

            DB::commit();


            $orderBlade = $order->toArray();

            $orderBlade['name'] = $order->client->name;

            foreach ($orderBlade['order_product'] as $key => $orderProduct) {
                if (isset($orderProduct['order_product_additional'])) {
                    $productAdditionalId = ProductAdditional::find($orderProduct['order_product_additional']['product_additional_id'])->additional_id;
                    $ingredientId = Additional::find($productAdditionalId)->ingredient_id;
                    $orderBlade['order_product'][$key]['order_product_additional']['name'] = Ingredient::find($ingredientId)->name;;
                }
                foreach ($orderProduct['product']['product_ingredient'] as $keyIngredient => $productIngredient) {
                    $orderBlade['order_product'][$key]['product']['product_ingredient'][$keyIngredient]['name'] = Ingredient::find($productIngredient['ingredient_id'])->name;
                }
            }

            Mail::to('basileus@gmail.com')->send(new OrderMail($orderBlade));

            return response()->json(new OrderResource($order), 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao criar pedido',
            ], 401);
        }
    }

    public function update(UpdateOrderRequest $request)
    {
        DB::beginTransaction();
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
                'orderProduct.product.productAdditional',
                'client'
            ]);

            DB::commit();
            return response()->json(new OrderResource($order), 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar pedido',
            ], 401);
        }
    }

    public function getMyOrders(Request $request)
    {
        try {
            $token = explode('|', $request->bearerToken());
            $userId = DB::table('personal_access_tokens')
                ->where('token', hash('sha256', $token[1]))
                ->value('tokenable_id');

            $client = Client::where('user_id', $userId)->first();

            $orders = Order::where('client_id', $client->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->load([
                    'orderProduct',
                    'orderProduct.orderProductAdditional',
                    'orderProduct.product',
                    'orderProduct.product.productPromotion',
                    'orderProduct.product.productIngredient',
                    'orderProduct.product.productAdditional',
                    'client'
                ]);

            return response()->json(OrderResource::collection($orders), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar pedidos',
            ], 401);
        }
    }

    public function exportFile (Request $request)
    {
        $orders = $this->index($request);

        $ordersFile = [];

        dd($orders->original->resource);

        foreach($orders->original->resource as $item) {
            array_push($ordersFile,
                [
                    'name' => $item->client->name,
                    'email' => $item->client->email,
                    'phone_number' => $item->client->phone_number,
                    'date_birth' => $item->client->date_birth,
                    'observation' => $item->observation,
                    'total_value' => $item->value,
                    'products' => $item->products->map(function ($product) {
                        return $product->product->name;
                    })->implode(', '),
                ]
            );
        }

        $data = new OrderExport(collect($ordersFile));

        return Excel::download($data, 'pedidos.csv');
    }
}
