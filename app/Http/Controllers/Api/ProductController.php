<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\StoreRequest;
use App\Http\Requests\Api\Product\UpdateRequest;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Utils\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(){
        $products = $this->productRepository->all();

        if ($products->isEmpty())
            throw new NotFoundHttpException();

        Response::success($products, "All Products", HttpResponse::HTTP_OK);
    }

    public function store(StoreRequest $request){
        $product = $this->productRepository->create($request->validationData());

        return Response::success($product, "Product Created", HttpResponse::HTTP_CREATED);
    }

    public function show(string $id){
        $product = $this->productRepository->findById($id);

        return Response::success($product, "Product Show", HttpResponse::HTTP_OK);
    }

    public function update(string $id, UpdateRequest $request){
        $updated = $this->productRepository->update($id, $request->validationData());

        return Response::success($updated, "Product Update", HttpResponse::HTTP_ACCEPTED);
    }

    public function delete(string $id){
        $deleted = $this->productRepository->deleteById($id);

        return Response::success($deleted, "Product Delete", HttpResponse::HTTP_ACCEPTED);
    }

}
