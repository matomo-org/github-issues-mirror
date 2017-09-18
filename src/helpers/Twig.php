<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace helpers;

class Twig {

    public static function setDateFormat(\Twig_Environment $environment)
    {
        $environment->getExtension("Twig_Extension_Core")->setDateFormat('F jS Y');
    }

    public static function registerFilter(\Twig_Environment $environment)
    {
        $environment->addFilter(static::getMarkdownFilter());
    }

    private static function getMarkdownFilter()
    {
        return new \Twig_SimpleFilter('markdown', function ($text) {
            $parser = new Markdown();
            return $parser->text($text);
        });
    }
}