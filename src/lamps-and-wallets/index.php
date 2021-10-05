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

$lampsAndWallets = $products->filter(function ($product) {
    // in_array(the_thing_you_are_looking_for, exists_in_this_array)
    // return true if the product type is a Lamp or Wallet
    // shorter
    // add item to array is easier
    return in_array($product['product_type'], ['Lamp','Wallet']);
//    return ($product['product_type'] === 'Lamp' || $product['product_type'] === 'Wallet');
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
