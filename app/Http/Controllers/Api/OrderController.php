<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\StoreRequest;
use App\Http\Requests\Api\Order\UpdateRequest;
use App\Repositories\Order\OrderRepository;
use App\Services\OrderService;
use App\Utils\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderController extends Controller
{
    protected OrderRepository $orderRepository;
    protected OrderService $orderService;

    public function __construct(OrderRepository $orderRepository, OrderService $orderService)
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

    public function store(StoreRequest $request)
    {
        return $this->orderService->placeOrder($request->validationData());
    }

    public function show(string $id)
    {

    }

    public function update(string $id, UpdateRequest $request)
    {
        return $this->orderService->placeOrder($request->validationData());
    }

    public function delete(string $id)
    {
        return $this->orderService->deleteOrder($id);
    }


}
