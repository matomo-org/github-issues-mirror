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
 * You can create a new personal access token here: https://github.com/settings/tokens/new .
 * The token should be set as clientId. ClientSecret is no longer looked at.
 * On the screen you don't need to give any permission. The default view public info permission is good enough.
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

/**
 * Number of pages to show before and after the current page in the pagination. e.g. default (5) on page 37:
 *  < 1 ... 32 33 34 35 36 *37** 38 39 40 40 42 ... 115 >
 */
define("PAGINATION_PADDING", 5);

/**
 * used in sitemap (without trailing slash)
 */
define("BASE_DOMAIN", "https://issues.matomo.org");

/**
 * URL to privacy policy (linked in footer)
 */
define("PRIVACY_POLICY_URL", "https://matomo.org/privacy-policy/");
