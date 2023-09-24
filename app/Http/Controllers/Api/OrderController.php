<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\OrderRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Services\OrderService;
use App\Utils\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;
    private OrderService $orderService;

    public function __construct(OrderRepositoryInterface $orderRepository, OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderRepository->all();

        if ($orders->isEmpty())
            throw new NotFoundHttpException();

        return Response::success($orders, "All Orders", HttpResponse::HTTP_OK);
    }

    public function store(OrderRequest $request)
    {
        return $this->orderService->storeOrder($request->validationData());
    }

    public function show(string $id)
    {
        $order = $this->orderRepository->findById($id);

        return Response::success($order, "Order Show", HttpResponse::HTTP_OK);
    }

    public function update(string $id, OrderRequest $request)
    {
        return $this->orderService->updateOrder($id, $request->validationData());
    }

    public function delete(string $id)
    {
        return $this->orderService->deleteOrder($id);
    }


}
