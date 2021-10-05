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


// so now we have a pipeline with just 3 operations
// filter.. we filter out any product that is not Lamp or Wallet
// we grab all of thoe variants
// and then we sum up the price fields of all of those variants

// that is a pretty expressive solution to this problem
// everything is done in these discrete steps
// there is no worrying the entire state of all of the operations
// that we are doing at the same time

// very linear and easy to understand
// as long as you are willing to take the time to get comfortable
// with programming in this style


$totalCost = $products->filter(function ($product) {
    return collect(['Lamp','Wallet'])->contains($product['product_type']);
})->flatMap(function ($product) {
    return $product['variants'];
})->sum('price');

dd($totalCost);
// 398
