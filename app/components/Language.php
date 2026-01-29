<?php

namespace App\Components;

use App\Lang\English;
use App\Lang\Greek;

class Language
{
    public static function getCurrentLang(): string
    {
        return $_SESSION['lang'] ?? $_COOKIE['lang'] ?? 'en';
    }

    public static function getTranslations(): array
    {
        $lang = self::getCurrentLang();

        switch ($lang) {
            case 'gr':
                return Greek::get();
            case 'en':
            default:
                return English::get();
        }
    }

    public static function t(string $key): string
    {
        static $translations = null;
        if ($translations === null) {
            $translations = self::getTranslations();
        }
        return $translations[$key] ?? $key;
    }

    public static function setLanguage(): void
    {
        if (isset($_GET['lang'])) {
            $selectedLang = $_GET['lang'];
            $_SESSION['lang'] = $selectedLang;
            setcookie('lang', $selectedLang, time() + (86400 * 30), '/');
        }
    }
}
