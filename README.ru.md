[English](README.md) | Русский

<p align="center">
<img src="logo.webp" alt="Gembla Traffic Rotator Logo" width="150">
<br><br>
  <a href="https://packagist.org/packages/gembla/traffic-rotator"><img src="https://img.shields.io/packagist/v/gembla/traffic-rotator?style=flat" alt="Latest Version"></a>
  <a href="https://packagist.org/packages/gembla/traffic-rotator"><img src="https://img.shields.io/packagist/dt/gembla/traffic-rotator?style=flat" alt="Total Downloads"></a>
  <a href="https://github.com/Gembla/traffic-rotator/blob/main/LICENSE"><img src="https://img.shields.io/packagist/l/gembla/traffic-rotator?style=flat" alt="License"></a>
  <a href="https://t.me/gembla_info"><img src="https://img.shields.io/badge/Telegram-Channel-blue?style=flat&logo=Telegram" alt="Telegram"></a>
</p>

# 🎰 Gambling Traffic Rotator & Micro-Smartlink

Простой, быстрый и эффективный PHP-ротатор трафика (Smartlink / ТДС на минималках) для арбитражников и вебмастеров в гемблинг-вертикали.

Позволяет распределять поток пользователей (игроков) по разным офферам, казино или посадочным страницам (landing pages) на основе заданных весов (процентного соотношения).

## ⚡ Возможности

* **Гибкое распределение весов:** Не обязательно подгонять сумму весов строго под 100%. Указывайте любые числа (например, 20, 50, 70), и трафик распределится пропорционально.
* **Продвинутое определение реального IP:** Автоматически извлекает настоящие IP-адреса пользователей за **Cloudflare** (`CF-Connecting-IP`), прокси-серверами вроде **Nginx** (`X-Forwarded-For`) или в стандартном окружении.
* **Безопасные редиректы:** Если HTTP-заголовки уже были отправлены вашим фреймворком или сервером, библиотека автоматически переключится на редирект через HTML/JavaScript вместо падения с ошибкой.
* **Опциональное логирование:** По умолчанию логирование отключено. Скрипт не будет создавать лишних файлов и тратить ресурсы диска, пока вы сами не передадите путь к файлу в конструктор класса.
* **Проверка доступности:** Легко проверяйте, загружены ли какие-либо офферы, перед выполнением логики с помощью метода `$rotator->hasOffers()`.

## ✅ Требования

Для работы библиотеки вам понадобятся:

* **PHP:** Версия `8.0` или выше
* **Composer:** Для управления зависимостями

## 🚀 Быстрый запуск и проверка (без установки)

Вы можете протестировать работу ротатора прямо сейчас на своем компьютере без скачивания сторонних библиотек:

1. Склонируйте этот репозиторий.
2. Сгенерируйте автозагрузчик (выполните в терминале проекта):
   ```bash
   composer dump-autoload
   ```
3. Запустите встроенный быстрый веб-сервер PHP:
   ```bash
   php -S localhost:8000
   ```
4. Откройте в браузере `http://localhost:8000`. Скрипт `index.php` мгновенно сработает и перенаправит вас на один из тестовых офферов.

## 📦 Установка в свой проект

Когда вы будете готовы внедрить ротатор в свою связку, установите пакет через Composer:

```bash
composer require gembla/traffic-rotator
```

## 💻 Использование в коде

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Gembla\TrafficRotator\Rotator;

// Проверка и автоматическое создание директории для логов, если она не существует
$logDir = __DIR__ . '/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

// Настройка динамического пути к лог-файлу (новый файл каждый месяц)
$logPath = $logDir . '/clicks_' . date('Y-m') . '.log'; 
$rotator = new Rotator($logPath);

// Добавляем ссылки на офферы казино и их "вес" (вероятность)
// В данном примере: 70% трафика уйдет на первый оффер, 30% — на второй
$rotator->addOffer('https://casino-brand-a.com', 20);
$rotator->addOffer('https://casino-brand-b.com', 50);
$rotator->addOffer('https://casino-brand-c.com', 30);
$rotator->addOffer('https://casino-brand-aa.com', 70);

// Автоматически выбирает ссылку и делает HTTP-редирект (header Location)
$rotator->redirect();
```

### Динамическая проверка офферов (опционально)

Если вы загружаете офферы динамически (например, из базы данных или через внешнее API), вы можете проверить, есть ли в ротаторе активные URL-адреса, перед выполнением редиректа:

```php
if ($rotator->hasOffers()) {
    $rotator->redirect();
} else {
    // Резервная логика, если доступных офферов нет
    header("Location: https://your-default-landing.com");
    exit;
}
```

## 📝 Пример формата логов

Каждый клик сохраняется в указанном вами лог-файле в следующем формате:
```text
[2026-06-29 06:19:56] [127.0.0.1] -> https://casino-brand-aa.com | Mozilla/5.0 (Linux ...) 
[2026-06-29 06:19:58] [127.0.0.2] -> https://casino-brand-aa.com | Mozilla/5.0 (Windows ...)
[2026-06-29 06:19:59] [127.0.0.3] -> https://casino-brand-aa.com | Mozilla/5.0 (Linux ...)
[2026-06-29 06:19:59] [127.0.0.4] -> https://casino-brand-b.com | Mozilla/5.0 (Linux ...)
```

## 📂 Структура проекта
- `src/Rotator.php` — основная логика распределения трафика.
- `index.php` — готовый пример для быстрого теста.
- `composer.json` — конфигурация автозагрузки PSR-4 под неймспейсом `Gembla\TrafficRotator`

## 📄 Лицензия

Этот проект распространяется под лицензией MIT. Вы можете свободно использовать его в своих связках и коммерческих проектах.



