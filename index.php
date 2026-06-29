<?php

require_once __DIR__ . '/vendor/autoload.php';

use Gembla\TrafficRotator\Rotator;

// Check and automatically create the logs directory if it does not exist
$logDir = __DIR__ . '/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

// Set up the dynamic path to the log file (a new file each month)
$logPath = $logDir . '/clicks_' . date('Y-m') . '.log';
$rotator = new Rotator($logPath);

// Add casino offer URLs and their respective weights
// The system automatically calculates percentages based on the total sum of all weights
$rotator->addOffer('https://casino-brand-a.com', 20);
$rotator->addOffer('https://casino-brand-b.com', 50);
$rotator->addOffer('https://casino-brand-c.com', 30);
$rotator->addOffer('https://casino-brand-aa.com', 70);

// Selects a random offer based on weight, records the click to the log, and executes a secure redirect
$rotator->redirect();
