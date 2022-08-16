<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace helpers;

use Monolog\Logger;
use SitemapPHP\Sitemap;
use Slim\App;

class SitemapHelper
{
    public static function createSitemap(Logger $logger) {
        $app = \Slim\Factory\AppFactory::create();
        require "../routes/page.php";
        $sitemap = new Sitemap(BASE_DOMAIN);
        $sitemap->setPath('../tmp/');

        $logger->info("fetching all pages for sitemap");
        $pages = Page::getAllPages();
        natsort($pages);
        foreach ($pages as $pageNumber) {
            $url = $app->getContainer()->get('router')->pathFor('page', [], [
                'page' => $pageNumber
            ]);
            $sitemap->addItem($url, 0.2);
        }

        $logger->info("fetching all issues for sitemap");
        $issues = Issue::getAllIssues();
        natsort($issues);
        foreach ($issues as $issueNumber) {
            $url = $app->getContainer()->get('router')->pathFor('issue', [
                'number' => $issueNumber
            ]);
            $sitemap->addItem($url, 0.5);
        }

        $logger->info("generating sitemap");
        $sitemap->createSitemapIndex(BASE_DOMAIN . "/", 'Today');
    }
}