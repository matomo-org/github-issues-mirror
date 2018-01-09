<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org/
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace helpers;

/**
 * Contains helper functions that deal with the filesystem.
 */
class Filesystem
{
    /**
     * Attempts to create a new directory. All errors are silenced.
     *
     * @param string $path The path of the directory to create.
     */
    public static function mkdir($path)
    {
        if (!is_dir($path)) {
            @mkdir($path, 0750, $recursive = true);
        }

        // try to overcome restrictive umask (mis-)configuration
        if (!is_writable($path)) {
            @chmod($path, 0755);
            if (!is_writable($path)) {
                @chmod($path, 0775);
                // enough! we're not going to make the directory world-writeable
            }
        }
    }
}
