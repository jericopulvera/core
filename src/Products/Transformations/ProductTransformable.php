<?php

namespace Laracommerce\Core\Products\Transformations;

use Laracommerce\Core\Products\Product;
use Illuminate\Support\Facades\Storage;

trait ProductTransformable
{
    /**
     * Transform the product
     *
     * @param Product $product
     * @return Product
     */
    protected function transformProduct(Product $product)
    {
        $file = Storage::disk('public')->exists($product->cover) ? $product->cover : null;

        $prod = new Product;
        $prod->id = (int) $product->id;
        $prod->name = $product->name;
        $prod->sku = $product->sku;
        $prod->slug = $product->slug;
        $prod->description = $product->description;
        $prod->cover = $file;
        $prod->quantity = $product->quantity;
        $prod->price = $product->price;
        $prod->status = $product->status;

        return $prod;
    }
}
