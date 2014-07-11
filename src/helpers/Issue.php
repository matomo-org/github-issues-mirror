<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace helpers;

class Issue {

    /**
     * Get all details of the given issue number.
     * Upfront you should check whether the issue actually exists by calling exists().
     *
     * @param  int $issueNumber
     * @return bool
     */
    public function getIssue($issueNumber)
    {
        $path       = $this->getPathToFile($issueNumber);
        $serialized = file_get_contents($path);

        return json_decode($serialized, true);
    }

    /**
     * Verify whether the given issue exists.
     * @param  int $issueNumber
     * @return bool
     */
    public function exists($issueNumber)
    {
        $path = $this->getPathToFile($issueNumber);

        return file_exists($path);
    }

    /**
     * Persist the given issue on the file system.
     *
     * @param array $issue
     * @param array $comments
     */
    public function save($issue, $comments)
    {
        if (empty($issue)) {
            return;
        }

        $issue['comments'] = $comments;

        $path = $this->getPathToFile($issue['number']);

        Filesystem::mkdir(dirname($path));
        file_put_contents($path, json_encode($issue));
    }

    private function getPathToFile($issueNumber)
    {
        $folderName = $issueNumber % 100; // prevent from having 10k files in one directory

        return sprintf('%s/../data/issues/%d/%d.json', dirname(__FILE__), $folderName, $issueNumber);
    }

}