<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace helpers;

use Github\HttpClient\CachedHttpClient;
use Guzzle\Http\Message\Response;

/**
 * This is to workaround this issue: https://github.com/KnpLabs/php-github-api/issues/133
 * "Pagination doesn't work correctly when CachedHttpClient is used"
 */
class CachedGithubClient extends CachedHttpClient
{
    /**
     * @var Response
     */
    private $actualLastResponse;

    /**
     * {@inheritdoc}
     */
    public function request($path, $body = null, $httpMethod = 'GET', array $headers = array(), array $options = array())
    {
        $this->actualLastResponse = parent::request($path, $body, $httpMethod, $headers, $options);

        return $this->actualLastResponse;
    }

    /**
     * @return Response
     */
    public function getLastResponse()
    {
        return $this->actualLastResponse;
    }

}
