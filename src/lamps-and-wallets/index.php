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


// original procedural loop based approach
// 3 levels of nested indentation
// 2 nested loops
// conditional check
$totalCost = 0;

foreach ( $products as $product) {
    if ($product['product_type'] === 'Lamp' || $product['product_type'] === 'Wallet'){
        foreach( $product["variants"] as $variant) {
            $totalCost += $variant["price"];
        }
    }
}

// in comparison to above approach
// just a series of flat transformations
// so we just remove any products that are not Lamp or Wallet
// then we get all of their variants
// then we flatten those variants so we have a single collection of variants
// then we convert each variant to its price
// then we just sum them up
$totalCost = $products->filter(function ($product) {
    return collect(['Lamp','Wallet'])->contains($product['product_type']);
})->map(function ($product) {
    return $product['variants'];
})->flatten(1)->map(function ($variant) {
    return $variant['price'];
})->sum();


dd($totalCost);
// 398
