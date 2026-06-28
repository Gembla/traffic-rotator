<?php

/**
 * Gembla Traffic Rotator
 *
 * A lightweight PHP traffic rotator (Smartlink / TDS alternative) 
 * for distributing players across multiple gambling offers based on weights.
 *
 * @package   Gembla\TrafficRotator
 * @author    Gembla
 * @license   MIT License
 * @link      https://github.com/Gembla/traffic-rotator
 */

namespace Gembla\TrafficRotator;

class Rotator
{
    /** @var array Holds offer URLs as keys and their respective weights as values */
    private array $offers = [];

    /**
     * Add a casino offer URL with its respective weight (e.g., 10, 20, 50).
     *
     * @param string $url    The destination URL of the offer.
     * @param int    $weight The probability weight assigned to this offer.
     * @return void
     */
    public function addOffer(string $url, int $weight = 1): void
    {
        $this->offers[$url] = $weight;
    }

    /**
     * Select a random offer URL based on the assigned weights.
     *
     * @return string The selected destination URL, or '#' if no offers exist.
     */
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

    /**
     * Execute an HTTP redirect to the selected offer and terminate script execution.
     *
     * @return void
     */
    public function redirect(): void
    {
        $url = $this->getRedirectUrl();
        header("Location: " . $url);
        exit;
    }
}
