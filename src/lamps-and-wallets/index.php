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
    return collect(['Lamp','Wallet'])->contains($product['product_type']);
});


//$totalCost = 0;
//$prices = [];
$prices = collect();
foreach ( $lampsAndWallets as $product) {
    foreach ($product["variants"] as $variant) {
//        $totalCost += $variant["price"];
        $prices[] = $variant['price'];
    }
}
//
//$totalCost = 0;
//foreach ($prices as $price) {
//    // now we can determine our total cost
//    $totalCost += $price;
//}
// this is going to take a function that is going to take $totalCost as its first parameter
// which is the total cost that we are trying to build up
// price as its second parameter
// and we want to return what the total cost should be for the next iteration
// which is return $totalCost + $price;
// passing the initial value of 0 (default is null)
$totalCost = $prices->reduce(function ($totalCost, $price) {
    return $totalCost + $price;
},0);

dd($totalCost);
// 398
