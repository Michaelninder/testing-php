<?php


$config = include __DIR__ . '/config.php';

$locale = $_GET['lang'] ?? $config['default_locale'];

$translations = include __DIR__ . "/lang/{$locale}.php";

function translate($key, $translations)
{
    return $translations[$key] ?? $key;
}

function getLocaleName($localeShort, $config)
{
    return $config['locales_map'][$localeShort] ?? $localeShort;
}

?>

<!DOCTYPE html>
<html lang="<?= $locale ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= translate('page_title', $translations) ?></title>
</head>
<body>
    <h1><?= translate('welcome_message', $translations) ?></h1>

    <nav>
        <ul>
            <?php foreach ($config['available_locales'] as $availableLocale): ?>
                <li>
                    <a href="?lang=<?= $availableLocale ?>">
                        <?= getLocaleName($availableLocale, $config) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>


    <h3><?= translate('greeting', $translations) ?></h3>
</body>
</html>