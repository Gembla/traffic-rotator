<?php

/**
 *  Пример
 */

require_once __DIR__ . '/vendor/autoload.php';

use Gembla\TrafficRotator\Rotator;

$rotator = new Rotator();

// Загружаем ссылки рефовода (например, на разные слоты или казино)
$rotator->addOffer('https://casino-1.com', 70); // 70% трафика пойдет сюда
$rotator->addOffer('https://casino-2.com', 30);   // 30% трафика пойдет сюда

// Перенаправляем пользователя
$rotator->redirect();
