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

$container = new \DI\Container();
\Slim\Factory\AppFactory::setContainer($container);

// Register component on container
$container->set('view', function () {
    $view = \Slim\Views\Twig::create(realpath("../templates/"), [
        'cache' => realpath('../tmp/templates_cache'),
        'debug' => DEBUG_ENABLED,
    ]);

    // Instantiate and add Slim specific extension
    $view->addExtension(new \Twig\Extension\DebugExtension());
    $twig = $view->getEnvironment();
    helpers\Twig::setDateFormat($twig);
    helpers\Twig::registerFilter($twig);

    $view->getEnvironment()->addGlobal('projectName', PROJECT_NAME);
    $view->getEnvironment()->addGlobal('githubOrganization', GITHUB_ORGANIZATION);
    $view->getEnvironment()->addGlobal('githubRepository', GITHUB_REPOSITORY);
    $view->getEnvironment()->addGlobal('matomoURL', MATOMO_URL);
    $view->getEnvironment()->addGlobal('matomoID', MATOMO_ID);
    $view->getEnvironment()->addGlobal('privacyPolicyURL', PRIVACY_POLICY_URL);

    return $view;
});

// Create App
$app = \Slim\Factory\AppFactory::create();

// Add Twig-View Middleware
$app->add(\Slim\Views\TwigMiddleware::createFromContainer($app));

$app->addErrorMiddleware(DEBUG_ENABLED, true, true);

require '../routes/page.php';

$app->run();