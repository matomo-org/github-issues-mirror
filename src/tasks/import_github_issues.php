<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

// Note: We do currently not clear existing pages/issues before writing the new files.
// This is to prevent 404 errors while the importer is running. Also if something goes wrong (eg Rate-Limit)
// we make sure not ending up having no issue/page files.

require '../vendor/autoload.php';
require '../config/config.php';

$client   = helpers\GithubImporter::buildClient(GITHUB_OAUTH_TOKEN);
$importer = new helpers\GithubImporter($client);

try {
    $importer->import(GITHUB_ORGANIZATION, GITHUB_REPOSITORY, NUMBER_OF_ISSUES_PER_PAGE);
} catch (Exception $e) {
    helpers\Mail::sendEmail('Import error', $e->getMessage(), PROJECT_EMAIL, PROJECT_EMAIL);

    throw $e;
}
