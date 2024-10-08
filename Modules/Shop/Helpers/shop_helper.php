<?php

if (!function_exists('shop_product_link')) {
    function shop_product_link($product)
    {
        $categorySlug = 'produk';

        // Pastikan category tidak null dan bisa menghitung jumlah category
        if (!is_null($product->category) && $product->category->count() > 0) {
            $categorySlug = $product->category->first()->slug;
        }

        $productSlug = $product->slug. '-'. $product->sku;

        return route('products.show', [$categorySlug, $productSlug]);
    }
}

if (!function_exists('shop_category_link')) {
    function shop_category_link($category)
    {
      return route('products.category', [$category->slug]);
    }
}
