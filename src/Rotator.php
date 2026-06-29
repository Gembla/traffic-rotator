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

    /** @var string|null Path to the file where logs will be written, or null if disabled */
    private ?string $logFilePath;

    /**
     * Class constructor to configure the rotator.
     *
     * @param string|null $logFilePath Path to the log file, or null to disable logging.
     */
    public function __construct(?string $logFilePath = null)
    {
        $this->logFilePath = $logFilePath;
    }

    /**
     * Add a casino offer URL with its respective weight (e.g., 10, 20, 50).
     *
     * @param string $url    The destination URL of the offer.
     * @param int    $weight The probability weight assigned to this offer.
     * @throws \InvalidArgumentException If the weight is less than 1.
     * @return void
     */
    public function addOffer(string $url, int $weight = 1): void
    {
        if ($weight < 1) {
            throw new \InvalidArgumentException("Weight must be a positive integer greater than 0.");
        }

        $this->offers[$url] = $weight;
    }

    /**
     * Check if there are any offers added to the rotator.
     * 
     * @return bool True if at least one offer exists, false otherwise.
     */
    public function hasOffers(): bool
    {
        return !empty($this->offers);
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
     * Get the real user IP address, handles Cloudflare and reverse proxies.
     * 
     * @return string
     */
    private function getRealIp(): string
    {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ipList[0]);
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }

    /**
     * Record click information into the log file.
     * 
     * @param string $url The selected offer URL.
     * @return void
     */
    private function logClick(string $url): void
    {
        // If logging is disabled, do nothing
        if (empty($this->logFilePath)) {
            return;
        }

        $date = date('Y-m-d H:i:s');
        $ip = $this->getRealIp();
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

        // Format: [Date] [IP] -> Selected URL | Browser
        $logLine = sprintf("[%s] [%s] -> %s | %s\n", $date, $ip, $url, $userAgent);

        file_put_contents($this->logFilePath, $logLine, FILE_APPEND | LOCK_EX);
    }

    /**
     * Execute an HTTP redirect to the selected offer and terminate script execution.
     *
     * @return void
     */
    public function redirect(): void
    {
        $url = $this->getRedirectUrl();

        if ($url !== '#') {
            $this->logClick($url);
        }

        if (!headers_sent()) {
            header("Location: " . $url);
            exit;
        } else {
            echo "<meta http-equiv='refresh' content='0;url=" . htmlspecialchars($url) . "'>";
            echo "<script>window.location.href='" . addslashes($url) . "';</script>";
            exit;
        }
    }
}
