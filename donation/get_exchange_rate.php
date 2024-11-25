<?php

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$apiKey = $_SERVER['API_TOKEN'];

$baseCurrency = 'USD';

if (isset($_GET['currency'])) {
    $targetCurrency = $_GET['currency'];

    $url = "http://data.fixer.io/api/latest?access_key=$apiKey&symbols=$baseCurrency,$targetCurrency";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data['success']) {
        $rate = $data['rates'][$baseCurrency] / $data['rates'][$targetCurrency];
        echo json_encode(['success' => true, 'rate' => $rate]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch exchange rates']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Currency not provided']);
}
?>
