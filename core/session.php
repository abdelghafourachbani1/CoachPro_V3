<?php

class Session
{

    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key){
        return isset($_SESSION[$key]);
    }

    public static function delete($key) {
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function setFlash($key, $message) {
        $_SESSION['flash'][$key] = $message;
    }

    public static function getFlash($key) {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }

    public static function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    public static function getUser() {
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'nom' => $_SESSION['user_nom'] ?? null,
            'prenom' => $_SESSION['user_prenom'] ?? null,
            'role' => $_SESSION['user_role'] ?? null
        ];
    }
}
