<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org/
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

require '../vendor/autoload.php';
require '../config/config.php';

date_default_timezone_set('UTC');
$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new \Slim\App($config);

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(realpath("../templates/"), [
        'cache' => realpath('../tmp/templates_cache'),
        'debug' => DEBUG_ENABLED,
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new \Twig_Extension_Debug());
    $twig = $view->getEnvironment();
    helpers\Twig::setDateFormat($twig);
    helpers\Twig::registerFilter($twig);

    $view->getEnvironment()->addGlobal('projectName', PROJECT_NAME);
    $view->getEnvironment()->addGlobal('githubOrganization', GITHUB_ORGANIZATION);
    $view->getEnvironment()->addGlobal('githubRepository', GITHUB_REPOSITORY);
    $view->getEnvironment()->addGlobal('matomoURL', MATOMO_URL);
    $view->getEnvironment()->addGlobal('matomoID', MATOMO_ID);

    return $view;
};

require '../routes/page.php';

$app->run();