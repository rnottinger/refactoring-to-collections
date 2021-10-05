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

// similiarly doing a map() where all you are doing is returning a single field
// from the items that you are mapping over
// is also a very common operation
// the collection class has a method called pluck()
// pluck takes a single parameter which is a string
// which represents the name of the key or property
// that you are trying to fetch
// within the items that you are mapping over
$totalCost = $products->filter(function ($product) {
    return collect(['Lamp','Wallet'])->contains($product['product_type']);
})->flatMap(function ($product) {
    return $product['variants'];
//})->map(function ($variant) {
//    return $variant['price'];
//})->sum();
})->pluck('price')->sum();


dd($totalCost);
// 398
