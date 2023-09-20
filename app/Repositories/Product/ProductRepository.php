<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
