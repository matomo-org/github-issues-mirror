<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org/
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

// Note: We do currently not clear existing pages/issues before writing the new files.
// This is to prevent 404 errors while the importer is running. Also if something goes wrong (eg Rate-Limit)
// we make sure not ending up having no issue/page files.

require '../vendor/autoload.php';
require '../config/config.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$logger = new Logger('import_log');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../tmp/import.log', Logger::DEBUG));
if (DEBUG_ENABLED) {
    $logger->pushHandler(new \Monolog\Handler\ErrorLogHandler());
}

$logger->info("authenticating");
$client   = helpers\GithubImporter::buildClient(GITHUB_CLIENT_ID, GITHUB_CLIENT_SECRET);
$importer = new helpers\GithubImporter($client, $logger);

try {
    $logger->info("starting import");
    $importer->import(GITHUB_ORGANIZATION, GITHUB_REPOSITORY, NUMBER_OF_ISSUES_PER_PAGE);
} catch (Exception $e) {
    helpers\Mail::sendEmail('Import error', $e->getMessage(), PROJECT_EMAIL, PROJECT_EMAIL);

    throw $e;
}
