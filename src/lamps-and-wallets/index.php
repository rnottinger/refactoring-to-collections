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

// we don't have just one big collection of variants
// instead we have a collection of collections of variants
// we need to figure out how to flatten this down
// to just one big collection of variants
// flatten is an operation that lets you flatten an array of nested arrays
// or a collection of nested collections
// to some arbitrary depth
// by default it flattens it to an infinite depth
// so it will flatten it down as much as it can to one top level
// in our case we know the variants are only 1 level deeper
// so we can just explicitly flatten 1 level
$variants = $lampsAndWallets->map(function ($product) {
    return $product['variants'];
})->flatten(1);

//dd($variants);

// so now that we have a collection of variants
// we can easily map these variants
// into their prices

//$prices = collect();
$prices = $variants->map(function ($variant) {
    return $variant['price'];
});

//dd($prices);


//foreach ( $lampsAndWallets as $product) {
//    foreach ($product["variants"] as $variant) {
//        $prices[] = $variant['price'];
//    }
//}

//$totalCost = $prices->reduce(function ($totalCost, $price) {
//    return $totalCost + $price;
//},0);

$totalCost = $prices->sum();

dd($totalCost);
// 398
