<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$apiKey = $_ENV['API_KEY'];

$baseCurrency = 'USD';

if (isset($_GET['currency'])) {
    $targetCurrency = $_GET['currency'];

    // API URL for Fixer.io
    $url = "http://data.fixer.io/api/latest?access_key=$apiKey&symbols=$baseCurrency,$targetCurrency";

    // Fetch exchange rates from Fixer.io
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Check if the response is valid
    if ($data['success']) {
        // Calculate the exchange rate
        $rate = $data['rates'][$baseCurrency] / $data['rates'][$targetCurrency];
        echo json_encode(['success' => true, 'rate' => $rate]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch exchange rates']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Currency not provided']);
}
?>
