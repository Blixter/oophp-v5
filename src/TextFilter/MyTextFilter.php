<?php

namespace Blixter\TextFilter;

// require __DIR__ . "/../config.php";
// require __DIR__ . "/../../vendor/autoload.php";


use Michelf\MarkdownExtra;

/**
 * Filter and format text content.
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 * @SuppressWarnings(StaticAccess)
 */
class MyTextFilter
{
    /**
     * @var array $filters Supported filters with method names of 
     *                     their respective handler.
     */
    private $filters = [
        "bbcode"    => "bbcode2html",
        "link"      => "makeClickable",
        "markdown"  => "markdown",
        "nl2br"     => "nl2br",
        "escaped"   => "esc"
    ];

    
    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array/str  $filters Array or comma separated string of filters to use.
     *
     * @return string with the formatted text.
     */
    public function parse($text, $filter)
    {   
        if (empty($filter)) {
            return $text;
        }

        if (is_string($filter)) {
            $filter = explode(',', $filter);
        }

        foreach ($filter as $fKey) {
            if (isset($this->filters[$fKey])) {
                $runFilter = $this->filters[$fKey];
                $text = $this->$runFilter($text);
            }
        }
        return $text;
    }



    /**
     * Helper, BBCode formatting converting to HTML.
     *
     * @param string $text The text to be converted.
     *
     * @return string the formatted text.
     */
    public function bbcode2html($text)
    {
        $search = [
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        ];

        $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        ];

        return preg_replace($search, $replace, $text);
    }



    /**
     * Make clickable links from URLs in text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string with formatted anchors.
     */
    public function makeClickable($text)
    {
        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            function ($matches) {
                return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";
            },
            $text
        );
    }



    /**
     * Format text according to Markdown syntax.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string as the formatted html text.
     */
    public function markdown($text)
    {
        return MarkdownExtra::defaultTransform($text);
    }



    /**
     * For convenience access to nl2br formatting of text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string the formatted text.
     */
    public function nl2br($text)
    {
        return nl2br($text);
    }

    /**
     * For convenience access to htmlescaped text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string the formatted text.
     */
    public function esc($text)
    {
        return htmlentities($text);
    }
}
