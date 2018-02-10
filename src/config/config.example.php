<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org/
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

/**
 * Will be displayed in the UI.
 */
define('PROJECT_NAME', 'Matomo');

/**
 * Emails will be sent to this address in case anything goes wrong during the import.
 */
define('PROJECT_EMAIL', 'developer@matomo.org');

/**
 * You can create a new application on the application settings page: https://github.com/settings/applications/new .
 * After adding an application the client id and secret will be displayed.
 * If you do not provide a client id and secret you will be limited to 60 requests per hour instead of 5000.
 */
define('GITHUB_CLIENT_ID', '');
define('GITHUB_CLIENT_SECRET', '');
define('GITHUB_ORGANIZATION', 'matomo-org');
define('GITHUB_REPOSITORY', 'matomo');
define('NUMBER_OF_ISSUES_PER_PAGE', 100);

/**
 * Set to true during development. Causes twig templates to automatically update on change and detailed
 * error messages will be displayed if enabled.
 */
define('DEBUG_ENABLED', false);

/**
 * Set list of file extensions that should be disallowed in links
 * see https://github.com/matomo-org/github-issues-mirror/issues/5
 */
define('FORBIDDEN_EXTENSIONS', ['swf', 'js', 'html', 'htm']);

/**
 * If you want to enable piwik tracking enter the URL to your piwik instance and the ID of the website here
 */
define('MATOMO_URL', false);
define('MATOMO_ID', false);
