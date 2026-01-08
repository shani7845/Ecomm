<?php

require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;

$base = 'http://127.0.0.1:8000';
$client = new Client([
    'base_uri' => $base,
    'cookies' => true,
    'http_errors' => false,
    'verify' => false,
]);

echo "GET /\n";
$res = $client->get('/');
$body = (string) $res->getBody();

if (preg_match('/meta name="csrf-token" content="([^"]+)"/', $body, $m)) {
    $token = $m[1];
    echo "CSRF token found: " . substr($token,0,10) . "...\n";
} else {
    echo "CSRF token not found in HTML.\n";
    exit(1);
}

// try to add product_id=1 qty=1
echo "POST /cart/add\n";
$add = $client->post('/cart/add', [
    'headers' => [ 'X-CSRF-TOKEN' => $token ],
    'form_params' => [ 'product_id' => 1, 'qty' => 1 ],
]);
echo "Add status: " . $add->getStatusCode() . "\n";
echo (string)$add->getBody() . "\n";

echo "POST /place-order\n";
$place = $client->post('/place-order', [
    'headers' => [ 'X-CSRF-TOKEN' => $token ],
]);
echo "Place status: " . $place->getStatusCode() . "\n";
echo (string)$place->getBody() . "\n";

echo "Done.\n";
