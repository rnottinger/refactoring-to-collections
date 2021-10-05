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
    // wrap this array of products in a collection so we can use the fluent api
    $products = collect(loadJson('products.json')['products']);
} catch (JsonException $e) {
    echo $e->getMessage();
}

// this is going to take a closure
// that takes a product
$lampsAndWallets = $products->filter(function ($product) {
    // and now I have to decide
    // what do we want to check
    // to decide that we should keep this product

    return ($product['product_type'] === 'Lamp' || $product['product_type'] === 'Wallet');
});


$totalCost = 0;

//foreach ( $products as $product) {
foreach ( $lampsAndWallets as $product) {
//    if ($product['product_type'] === 'Lamp' || $product['product_type'] === 'Wallet') {
    foreach ($product["variants"] as $variant) {
        $totalCost += $variant["price"];
    }
//    }
    dd($totalCost);
    // 199
}