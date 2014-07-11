<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

/**
 * Will be displayed in the UI.
 */
define('PROJECT_NAME', 'Piwik');

/**
 * Emails will be sent to this address in case anything goes wrong during the import.
 */
define('PROJECT_EMAIL', 'developer@piwik.org');

/**
 * See https://developer.github.com/v3/oauth_authorizations/#create-a-new-authorization for how to create a new token.
 * If you do not provide an OAuth2 Token you will be limited to 60 requests per hour instead of 5000.
 */
define('GITHUB_OAUTH_TOKEN', '');
define('GITHUB_ORGANIZATION', 'piwik');
define('GITHUB_REPOSITORY', 'piwik');
define('NUMBER_OF_ISSUES_PER_PAGE', 100);

/**
 * Set to true during development. Causes twig templates to automatically update on change and detailed
 * error messages will be displayed if enabled.
 */
define('DEBUG_ENABLED', false);
