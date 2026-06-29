English | [Русский](README.ru.md)

<p align="center">
<img src="logo.webp" alt="Gembla Traffic Rotator Logo" width="150">
<br><br>
  <a href="https://packagist.org/packages/gembla/traffic-rotator"><img src="https://img.shields.io/packagist/v/gembla/traffic-rotator?style=flat" alt="Latest Version"></a>
  <a href="https://packagist.org/packages/gembla/traffic-rotator"><img src="https://img.shields.io/packagist/dt/gembla/traffic-rotator?style=flat" alt="Total Downloads"></a>
  <a href="https://github.com/Gembla/traffic-rotator/blob/main/LICENSE"><img src="https://img.shields.io/packagist/l/gembla/traffic-rotator?style=flat" alt="License"></a>
  <a href="https://t.me/gembla_info"><img src="https://img.shields.io/badge/Telegram-Channel-blue?style=flat&logo=Telegram" alt="Telegram"></a>
</p>

# 🎰 Gambling Traffic Rotator & Micro-Smartlink

A simple, fast, and efficient PHP traffic rotator (a lightweight Smartlink / TDS) tailored for affiliates and media buyers in the Gambling vertical.

It allows you to distribute the flow of users (players) across various offers, casinos, or landing pages based on pre-configured weights (probability ratios).

## ⚡ Features

* **Flexible Weight Distribution:** No need to strictly match a 100% total. Add any weights (e.g., 20, 50, 70), and the traffic will be proportionally distributed.
* **Advanced Real IP Detection:** Automatically extracts genuine user IP addresses behind **Cloudflare** (`CF-Connecting-IP`), reverse proxies like **Nginx** (`X-Forwarded-For`), or standard environments.
* **Fail-Safe Redirects:** If HTTP headers have already been sent by your framework or server, the library automatically falls back to an HTML/JavaScript redirect instead of crashing.
* **Optional Logging:** Logging is disabled by default. The script will not create unnecessary files or consume disk resources unless you explicitly pass a file path to the class constructor.
* **Availability Check:** Easily check if any offers are loaded before executing logic with the `$rotator->hasOffers()` method.

## ✅ Requirements

To run this library, you will need:

* **PHP:** Version `8.0` or higher
* **Composer:** For dependency management

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

```

### Dynamic Offers Checking (Optional)

If you load your offers dynamically (e.g., from a database or an external API), you can check if the rotator has any active URLs before triggering the redirect:

```php
if ($rotator->hasOffers()) {
    $rotator->redirect();
} else {
    // Fallback logic if no offers are available
    header("Location: https://your-default-landing.com");
    exit;
}
```

## 📝 Log Format Example

Every click is stored in your specified log file in the following format:
```text
[2026-06-29 06:19:56] [127.0.0.1] -> https://casino-brand-aa.com | Mozilla/5.0 (Linux ...) 
[2026-06-29 06:19:58] [127.0.0.2] -> https://casino-brand-aa.com | Mozilla/5.0 (Windows ...)
[2026-06-29 06:19:59] [127.0.0.3] -> https://casino-brand-aa.com | Mozilla/5.0 (Linux ...)
[2026-06-29 06:19:59] [127.0.0.4] -> https://casino-brand-b.com | Mozilla/5.0 (Linux ...)
```

## 📂 Project Structure

- `src/Rotator.php` — Core traffic distribution logic.
- `index.php` — Ready-to-use example for quick testing.
- `composer.json` — Composer configuration with PSR-4 autoloading under the `Gembla\TrafficRotator` namespace

## 📄 License

This project is open-source software licensed under the MIT License. You are free to use it in your marketing setups and commercial projects.
