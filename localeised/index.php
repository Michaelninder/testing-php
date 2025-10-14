<?php


$config = include __DIR__ . '/config.php';

$loclae = $_GET['lang'] ?? $config['default_locale'];

$translations = include __DIR__ . 'lang/' . $locale . '.php';
function translate($key, $translations) {
    return $translations[$key] ?? $key;
}

?>