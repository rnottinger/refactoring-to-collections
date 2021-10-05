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
//var_dump($products);

// build up this total cost as we loop over all of the products
// adding the price of a variant
// anytime we find a variant that meets our criteria
$totalCost = 0;

foreach ( $products as $product) {
    // working with an individual product
    // but we don't want to include that product if is not a lamp or a wallet
    if ($product['product_type'] === 'Lamp' || $product['product_type'] === 'Wallet'){
        // so now we have a product that is either a Lamp or a Wallet
//        dd($product);
        // so the next thing we need to do is loop over the variants in that product
        foreach( $product["variants"] as $variant) {
            // we want to find the price of each variant
            // and add that to our total cost
            $totalCost += $variant["price"];
            // these are strings
            // but because php is loosely typed
            // we are still able to add these together
            // and they will behave as expected
            // so we don't need to worry about any casting
        }
        dd($totalCost);
        // so we will use this
        // to compare against any refactoring that we will do
        // to make sure we are getting the right results
        // 199
    }
}