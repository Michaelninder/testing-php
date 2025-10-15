<?php

$config = include __DIR__ . '/config.php';

$locale = $_GET['lang'] ?? config('default_locale');

if (!in_array($locale, config('available_locales'), true)) {
    $locale = config('default_locale');
}

$translations = include __DIR__ . "/lang/{$locale}.php";

function config($key, $default = null)
{
    global $config;
    return $config[$key] ?? $default;
}

function translate($key)
{
    global $translations;
    return $translations[$key] ?? $key;
}

function getLocaleName($localeShort)
{
    return config("locales_map")[$localeShort] ?? $localeShort;
}

function revertBool($value)
{
    return !$value;
}

function generateRoute($route, $params = [])
{
    global $locale;

    if (!isset($params['lang'])) {
        if ($locale !== config('default_locale')) {
            $params['lang'] = $locale;
        }
    } /* else {
        if ($params['lang'] === config('default_locale')) {
            unset($params['lang']);
        }
    } */

    $queryString = http_build_query($params);

    $url = $route;
    if ($queryString) {
        $separator = strpos($url, '?') === false ? '?' : '&';
        $url .= $separator . $queryString;
    }

    return $url;
}

?>

<!DOCTYPE html>
<html lang="<?= $locale ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= translate('page_title') ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1><?= translate('welcome_message') ?></h1>
    </header>

    <nav>
        <ul>
            <?php foreach (config('available_locales') as $availableLocale): ?>
                <li>
                    <a href="<?= generateRoute('', ['lang' => $availableLocale]) ?>"
                       class="<?= $locale === $availableLocale ? 'active' : '' ?>">
                        <?= getLocaleName($availableLocale) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <main>
        <h3><?= translate('greeting') ?></h3>
    </main>
</body>
</html>

<pre><?php print_r($translations, revertBool(config('debug_mode'))); ?></pre>
<pre><?php print_r($config, revertBool(config('debug_mode'))); ?></pre>