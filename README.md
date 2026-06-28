English | [Русский](README.ru.md)

<p align="center">
<img src="logo.webp" alt="Gembla Traffic Rotator Logo" width="150">
<br><br>
<a href="https://t.me/gembla_info"><img src="https://poser.pugx.org/gembla/traffic-rotator/v" alt="Latest Version"></a>
  <a href="https://t.me/gembla_info"><img src="https://poser.pugx.org/gembla/traffic-rotator/downloads" alt="Total Downloads"></a>
  <a href="https://t.me/gembla_info"><img src="https://poser.pugx.org/gembla/traffic-rotator/license" alt="License"></a>
  <a href="https://t.me/gembla_info"><img src="https://img.shields.io/badge/Telegram-Channel-blue?style=flat&logo=Telegram" alt="Telegram"></a>
</p>

# 🎰 Gambling Traffic Rotator & Micro-Smartlink

A simple, fast, and efficient PHP traffic rotator (a lightweight TDS / Smartlink alternative) designed for affiliate marketers and referral publishers in the gambling vertical.

It allows you to distribute user traffic (players) across multiple offers, casinos, or landing pages based on predefined weights (percentage ratios).

## 🚀 Quick Start & Testing (No Setup Required)

You can test the rotator locally on your machine right away without downloading any external third-party libraries:

1. Clone this repository.
2. Generate the autoloader by running the following command in your project terminal:
   ```bash
   composer dump-autoload
   ```
3. Start the built-in PHP development web server:
   ```bash
   php -S localhost:8000
   ```
4. Open `http://localhost:8000` in your browser. The `index.php` script will execute instantly and redirect you to one of the test offers.

## 📦 Installation

When you are ready to integrate the rotator into your funnel, install the package via Composer:

```bash
composer require gembla/traffic-rotator
```

## 💻 Code Usage

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Gembla\TrafficRotator\Rotator;

$rotator = new Rotator();

// Add casino offer URLs and their respective weights (probabilities)
// In this example: 70% of traffic goes to Offer A, 30% goes to Offer B
$rotator->addOffer('https://casino-brand-a.com', 70);
$rotator->addOffer('https://casino-brand-b.com', 30);

// Automatically selects a URL and performs an HTTP redirect (Location header)
$rotator->redirect();
```

## 📂 Project Structure

- `src/Rotator.php` — Core traffic distribution logic.
- `index.php` — Ready-to-use example for quick testing.
- `composer.json` — Composer configuration with PSR-4 autoloading under the `Gembla\TrafficRotator` namespace

## 📄 License

This project is open-source software licensed under the MIT License. You are free to use it in your marketing setups and commercial projects.
