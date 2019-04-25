<?php

declare(strict_types=1);

namespace App\Core\Helpers;

abstract class Server
{
    public function serverWithUri(string $uri): string
    {
        $protocol = self::isHttps() ? 'https://' : 'http://';
        $server = $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'];

        return $protocol . $server . $uri;
    }

    public static function isHttps(): bool
    {
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return true;
        }
        elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
            return true;
        }
        elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return true;
        }

        return false;
    }
}
