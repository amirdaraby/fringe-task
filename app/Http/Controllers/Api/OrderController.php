<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(){

    }

    public function store(){

    }

    public function show(string $id){

    }

    public function update(string $id){

    }

    public function delete(string $id){

    }


}
