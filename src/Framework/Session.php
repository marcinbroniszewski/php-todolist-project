<?php

declare(strict_types=1);

namespace Framework;

class Session
{
    //Start the session
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    //Set a session key/value pair
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    //Get a session value by the key
    public static function get(string $key, mixed $default = null): mixed
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    //Check if session key exists
    public static function check(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    //Clear session by the key
    public static function clear(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    //Clear all sessions
    public static function clearAll() : void {
        session_unset();
        session_destroy();
    }
}
