<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$aiService = app('App\Services\AIService');

echo "Testing AIService...\n";
$result = $aiService->predictGrade(8.5, 7.5, 8.0, 1, 3);

if ($result) {
    echo "✓ SUCCESS!\n";
    echo "Prediction: " . $result['prediction'] . "\n";
    echo "Confidence: " . $result['confidence'] . "%\n";
    print_r($result);
} else {
    echo "✗ FAILED - Check storage/logs/laravel.log for details\n";
}
