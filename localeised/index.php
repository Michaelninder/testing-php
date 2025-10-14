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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1><?= translate('welcome_message', $translations) ?></h1>
    </header>

    <nav>
        <ul>
            <?php foreach ($config['available_locales'] as $availableLocale): ?>
                <li>
                    <a href="?lang=<?= $availableLocale ?>"
                       class="<?= $locale === $availableLocale ? 'active' : '' ?>">
                        <?= getLocaleName($availableLocale, $config) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <main>
        <h3><?= translate('greeting', $translations) ?></h3>
    </main>
</body>
</html>