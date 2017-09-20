<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace helpers;

class Page
{

    /**
     * Get all details of the given page number.
     * Upfront you should check whether the page actually exists by calling exists().
     *
     * @param  int $pageNumber
     * @return bool
     */
    public function getPage($pageNumber) {
        $path = $this->getPathToFile($pageNumber);
        $content = file_get_contents($path);

        return json_decode($content, true);
    }

    /**
     * Verify whether the given page number exists.
     * @param  int $pageNumber
     * @return bool
     */
    public function exists($pageNumber) {
        $path = $this->getPathToFile($pageNumber);

        return file_exists($path);
    }

    /**
     * Persist the given page on the file system.
     *
     * @param array $issues
     * @param int $numIssuesPerPage
     */
    public function save($issues, $numIssuesPerPage) {
        if (empty($issues)) {
            return;
        }

        $pages = array_chunk($issues, $numIssuesPerPage);

        foreach ($pages as $index => $issuesInPage) {
            $pageNumber = $index + 1;

            $page = array(
                'numPages' => count($pages),
                'previousPage' => $pageNumber - 1,
                'currentPage' => $pageNumber,
                'nextPage' => $pageNumber + 1,
                'issues' => $this->formatIssues($issuesInPage)
            );

            $path = $this->getPathToFile($pageNumber);
            file_put_contents($path, json_encode($page));
        }
    }

    private function getPathToFile($pageNumber) {
        return sprintf('%s/../data/pages/%d.json', dirname(__FILE__), $pageNumber);
    }

    private function formatIssues($issuesInPage) {
        $formatted = array();

        foreach ($issuesInPage as $issue) {
            $formatted[] = array(
                'number' => $issue['number'],
                'title' => $issue['title'],
                'state' => $issue['state'],
                'user' => array(
                    'login' => $issue['user']['login']
                ),
                'created_at' => $issue['created_at'],
                'labels' => $issue['labels']
            );
        }

        return $formatted;
    }

    public function getPaginationArray($numPages, $page, $padding = 2) {
        $pages = [1];
        $i = 2;
        while ($i <= $numPages) {
            if ($i < ($page - $padding - 1)) {
                $pages[] = "d";
                $i = $page - $padding;
            } elseif (($i > ($page + $padding)) && ($numPages > ($page + $padding + 2))) {
                # Wenn (
                $pages[] = "d";
                $i = $numPages;
            }
            $pages[] = $i;
            $i++;
        }
        return $pages;
    }

}