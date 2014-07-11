<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

require '../vendor/autoload.php';
require '../config/config.php';

date_default_timezone_set('UTC');

$app = new \Slim\Slim(array(
    'view'  => new \Slim\Views\Twig(),
    'debug' => DEBUG_ENABLED
));

/** @var \Slim\Views\Twig $view */
$view = $app->view();
$view->parserOptions = array(
    'charset'    => 'utf-8',
    'debug'      => DEBUG_ENABLED,
    'cache'      => realpath('../tmp/templates_cache'),
    'autoescape' => true
);
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension()
);
$view->setTemplatesDirectory(realpath('../templates'));
helpers\Twig::setDateFormat($view->getEnvironment());
helpers\Twig::registerFilter($view->getEnvironment());

require '../routes/page.php';

$app->run();