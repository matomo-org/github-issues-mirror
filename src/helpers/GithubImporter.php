<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace helpers;

use Cache\Adapter\Filesystem\FilesystemCachePool;
use Github\Client;
use Github\ResultPager;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
class GithubImporter {

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function import($organization, $repository, $numIssuesPerPage)
    {
        $issues = $this->fetchAllIssues($organization, $repository);

        $issuesList = new Page();
        $issuesList->save($issues, $numIssuesPerPage);

        foreach ($issues as $issue) {
            $comments = $this->fetchAllComments($organization, $repository, $issue);

            $instance = new Issue();
            $instance->save($issue, $comments);
        }
    }

    public static function buildClient($clientId, $clientSecret)
    {
        $filesystemAdapter = new Local(realpath('../tmp/github_api_cache'));
        $filesystem = new Filesystem($filesystemAdapter);

        $pool = new FilesystemCachePool($filesystem);
        $client = new Client();
        $client->addCache($pool);

        if (!empty($clientId) && !empty($clientSecret)) {
            $client->authenticate($clientId, $clientSecret, Client::AUTH_URL_CLIENT_ID);
        }

        return $client;
    }

    private function fetchAllIssues($organization, $repository)
    {
        $params = array(
            $organization,
            $repository,
            array('filter' => 'all', 'state' => 'all', 'direction' => 'desc', 'sort' => 'updated')
        );

        $paginator = new ResultPager($this->client);
        $issuesApi = $this->client->api('issue');
        $issues    = $paginator->fetchAll($issuesApi, 'all', $params);

        return $issues;
    }

    private function fetchAllComments($organization, $repository, $issue)
    {
        if (empty($issue['comments'])) {
            return array();
        }

        $params = array($organization, $repository, $issue['number']);

        $paginator   = new ResultPager($this->client);
        $commentsApi = $this->client->api('issue')->comments();
        $comments    = $paginator->fetchAll($commentsApi, 'all', $params);

        return $comments;
    }
}