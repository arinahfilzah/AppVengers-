<?php
// debug.php in your project root
echo "=== DEBUG START ===\n";
echo "PHP Version: " . PHP_VERSION . "\n";

// Check vendor autoload
echo "Checking vendor/autoload.php... ";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "EXISTS\n";
    require_once __DIR__ . '/vendor/autoload.php';
    echo "Autoload loaded\n";
} else {
    echo "NOT FOUND\n";
}

// Check bootstrap
echo "Checking bootstrap/app.php... ";
if (file_exists(__DIR__ . '/bootstrap/app.php')) {
    echo "EXISTS\n";
    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "Bootstrap loaded\n";
    
    // Try to create request
    $request = Illuminate\Http\Request::capture();
    echo "Request captured\n";
    
    // Try to handle
    $response = $app->handle($request);
    echo "Request handled\n";
} else {
    echo "NOT FOUND\n";
}

echo "=== DEBUG END ===\n";