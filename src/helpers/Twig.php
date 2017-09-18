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
        $environment->addFilter(static::getLinkToPageFilter());
        $environment->addFilter(static::getLinkToIssueFilter());
    }

    private static function getMarkdownFilter()
    {
        return new \Twig_SimpleFilter('markdown', function ($text) {
            $parser = new Markdown();
            return $parser->text($text);
        });
    }

    private static function getLinkToPageFilter()
    {
        return new \Twig_SimpleFilter('pageLink', function ($page) {
            if (1 === (int) $page) {
                return '/';
            }

            return '/?page=' . (int) $page;
        }, array('is_safe' => array('all')));
    }

    private static function getLinkToIssueFilter()
    {
        return new \Twig_SimpleFilter('issueLink', function ($number) {

            return '/' . (int) $number;
        }, array('is_safe' => array('all')));
    }
}