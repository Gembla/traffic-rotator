<?php

namespace Gembla\TrafficRotator;

class Rotator
{
    private array $offers = [];

    // Добавляем ссылку на казино и её вес (например, 10, 20, 50)
    public function addOffer(string $url, int $weight = 1): void
    {
        $this->offers[$url] = $weight;
    }

    // Выбираем случайную ссылку на основе весов
    public function getRedirectUrl(): string
    {
        if (empty($this->offers)) {
            return '#';
        }

        $totalWeight = array_sum($this->offers);
        $random = rand(1, $totalWeight);
        $currentWeight = 0;

        foreach ($this->offers as $url => $weight) {
            $currentWeight += $weight;
            if ($random <= $currentWeight) {
                return $url;
            }
        }

        return (string) array_key_first($this->offers);
    }

    // Выполняем редирект игрока
    public function redirect(): void
    {
        $url = $this->getRedirectUrl();
        header("Location: " . $url);
        exit;
    }
}
