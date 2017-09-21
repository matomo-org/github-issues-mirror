<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace helpers;


class Markdown extends \Parsedown
{

    /**
     * Transform markdown to HTML. The HTML will be purified to prevent XSS.
     *
     * @param  string $markdown
     * @return string
     */
    public function text($markdown) {
        $markdown = $this->parseMentions($markdown);
        $this->setBreaksEnabled(true);
        $html = parent::text($markdown);

        $html = $this->removeUnsafeFileExtensions($html);
        return $this->purifyHtml($html);
    }

    private function parseMentions($markdown) {
        $regex = '/\@(\w+)/';
        return preg_replace($regex, "<a class='mention' href='https://github.com/$1'>$0</a>", $markdown);
    }

    /**
     * <a href="http://issues.piwik.org/attachments/1199/swelen_dateslider.swf">swelen_dateslider.swf</a>
     * to
     * <a href="http://issues.piwik.org/">swelen_dateslider.swf</a>
     * @param $html
     * @return string html
     */
    private function removeUnsafeFileExtensions($html) {
        $regex = '/attachments\/(.*?)\.(' . implode("|", FORBIDDEN_EXTENSIONS) . ')/';
        return preg_replace($regex, "", $html);
    }

    private function purifyHtml($html) {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('HTML.Allowed', 'p,strong,em,b,a[href],i,span,ul,ol,li,cite,code,pre,br,blockquote,img');
        $config->set('HTML.AllowedAttributes', 'src, height, width, alt, href, class');
        $config->set('URI.AllowedSchemes', array('http' => true, 'https' => true, 'mailto' => true, 'ftp' => true));
        $config->set('HTML.TargetBlank', true);

        $purifier = new \HTMLPurifier($config);

        return $purifier->purify($html);
    }

}