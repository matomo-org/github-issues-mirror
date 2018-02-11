<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org/
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace helpers;

class Twig
{

    public static function setDateFormat(\Twig_Environment $environment) {
        $environment->getExtension("Twig_Extension_Core")->setDateFormat('F jS Y');
    }

    public static function registerFilter(\Twig_Environment $environment) {
        $environment->addFilter(static::getMarkdownFilter());
        $environment->addFilter(static::getColorFilter());
        $environment->addFunction(static::getPaginationFunction());
    }

    private static function getMarkdownFilter() {
        return new \Twig_SimpleFilter('markdown', function ($text) {
            $parser = new Markdown();
            return $parser->text($text);
        });
    }

    private static function getColorFilter() {
        return new \Twig_SimpleFilter(
        /**
         * modified from https://24ways.org/2010/calculating-color-contrast/
         * @param $colorstring "#ffffff"
         * @return string
         */
            'textcolor', function ($hexcolor) {
            $r = hexdec(substr($hexcolor, 0, 2));
            $g = hexdec(substr($hexcolor, 2, 2));
            $b = hexdec(substr($hexcolor, 4, 2));
            $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
            return ($yiq >= 128) ? 'black' : 'white';
        });
    }

    private static function getPaginationFunction() {
        return new \Twig_Function('paginationFunction', function ($numPages, $page) {
            $padding = PAGINATION_PADDING;
            $pages = [1];
            $i = 2;
            while ($i <= $numPages) {
                if ($i < ($page - $padding - 1)) {
                    $pages[] = "d";
                    $i = $page - $padding;
                } elseif (($i > ($page + $padding)) && ($numPages > ($page + $padding + 2))) {
                    $pages[] = "d";
                    $i = $numPages;
                }
                $pages[] = $i;
                $i++;
            }
            return $pages;
        });
    }
}