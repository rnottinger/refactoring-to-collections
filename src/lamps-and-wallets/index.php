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


// this is looking pretty good but there is actually some things that we can do to simplify this even more
// notice the combination where we do the map operation then we do the flatten() operation
// this is a common transformation to have to do when working with nested data
// so common in fact that there is actually a name for this operation called flatMap
// where you map some nested objects
// and then flatten them down a level
// and the collection class has a flatMap operation that we can use
// so instead of calling map() then flatten()
// we can just call flatMap() instead
//
$totalCost = $products->filter(function ($product) {
    return collect(['Lamp','Wallet'])->contains($product['product_type']);
//})->map(function ($product) {
})->flatMap(function ($product) {
    return $product['variants'];
//})->flatten(1)->map(function ($variant) {
})->map(function ($variant) {
    return $variant['price'];
})->sum();


dd($totalCost);
// 398
