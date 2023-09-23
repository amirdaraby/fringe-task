<?php

namespace App\Services;

use App\Repositories\Order\OrderRepository;
use App\Repositories\Product\ProductRepository;
use App\Utils\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OrderService
{
    protected ProductRepository $productRepository;
    protected OrderRepository $orderRepository;

    public function __construct(ProductRepository $productRepository, OrderRepository $orderRepository)
    {
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    public function placeOrder(array $validatedData): object
    {
        $order = $this->orderRepository->create([]);

        $products = [];
        $orderTotalPrice = 0;
        $orderCount = 0;


        foreach ($validatedData["products"] as $item) {
            $product = $this->productRepository->findById($item["id"]);

            if ($product->inventory < $item["quantity"]) {
                return Response::error("product: {$product->name}'s inventory is less than requested quantity", HttpResponse::HTTP_BAD_REQUEST);
            }

            $orderTotalPrice += $product->price * $item["quantity"];

            $product->inventory -= $item["quantity"];

            $orderCount += $item["quantity"];

            $orderProducts [] = [
                "id" => $product->id,
                "quantity" => $item["quantity"],
                "inventory" => $product->inventory,
                "price" => $product->price
            ];

            $product->save();
        }

        $order->products = $orderProducts;
        $order->total_price = $orderTotalPrice;
        $order->count = $orderCount;

        $order->save();

        return Response::success($order, "Order Created", HttpResponse::HTTP_CREATED);
    }

    public function updateOrder(array $validatedData)
    {

    }

    public function deleteOrder(string $id)
    {

    }
}
