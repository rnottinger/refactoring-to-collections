<?php
// php -s localhost:8000
// http://localhost:8000/src/lamps-and-wallets

require_once '../../vendor/autoload.php';


/**
 * @throws JsonException
 */
function loadJson($path)
{
    return json_decode(file_get_contents(__DIR__ . '/' . $path), true, 512, JSON_THROW_ON_ERROR);
}

/**
 * @param $var
 */
function dd($var)
{
    var_dump($var);
    die();
}

// https://shopify.dev/api/admin-rest/2021-07/resources/product#[get]/admin/api/2021-07/products.json
//$url = 'http://shopicruit.myshopify.com/products.json';
//$productJson = json_decode(file_get_contents($url), true);
//$products = collect($productJson['products']);


try {
    $products = collect(loadJson('products.json')['products']);
} catch (JsonException $e) {
    echo $e->getMessage();
}


$totalCost = $products->filter(function ($product) {
    return collect(['Lamp','Wallet'])->contains($product['product_type']);
})->map(function ($product) {
    return $product['variants'];
})->flatten(1)->map(function ($variant) {
    return $variant['price'];
})->sum();


dd($totalCost);
// 398

// $totalCost is just the result of calling $prices->sum()
// we can move ->sum to the end of $prices pipeline above

// then notice that $totalCost is just mapping the variants
// so we can move the ->map() operation to the end of the variants pipeline
