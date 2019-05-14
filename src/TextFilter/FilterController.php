<?php
namespace Blixter\TextFilter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * 
 */
class FilterController implements AppInjectableInterface
{
    use AppInjectableTrait;


    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Initalise a filter object.
        $this->filter = new MyTextFilter();
        $this->markdownText = file_get_contents(__DIR__ . "/text/sample.md");
        $this->bbcodeText = file_get_contents(__DIR__ . "/text/bbcode.txt");
        $this->linkText = file_get_contents(__DIR__ . "/text/link.txt");
        $this->nl2brText = "Här har vi text\noch detta skall stå på en ny rad efter filtrering.";
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/markdown
     * 
     * @return object
     *
     */
    public function markdownActionGet() : object
    {
        $filteredMarkdownText = $this->filter->parse($this->markdownText, ["markdown"]);
        $data = [
            "title" => "Textfilter - Markdown",
            "markdownText" => $this->markdownText,
            "filteredMarkdownText" => $filteredMarkdownText
        ];

        $this->app->page->add("filter/markdown", $data);

        return $this->app->page->render($data);
    }

        /**
     * This method is handler for the route:
     * GET mountpoint/markdown
     * 
     * @return object
     *
     */
    public function bbcodeActionGet() : object
    {
        $filteredBbcodeText = $this->filter->parse($this->bbcodeText, ["bbcode"]);
        $data = [
            "title" => "Textfilter - BBcode",
            "bbcodeText" => $this->bbcodeText,
            "filteredBbcodeText" => $filteredBbcodeText
        ];

        $this->app->page->add("filter/bbcode", $data);

        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/markdown
     * 
     * @return object
     *
     */
    public function linkActionGet() : object
    {
        $filteredLinkText = $this->filter->parse($this->linkText, ["link"]);
        $data = [
            "title" => "Textfilter - Links",
            "linkText" => $this->linkText,
            "filteredLinkText" => $filteredLinkText
        ];

        $this->app->page->add("filter/link", $data);

        return $this->app->page->render($data);
    }

        /**
     * This method is handler for the route:
     * GET mountpoint/nl2br
     * 
     * @return object
     *
     */
    public function nl2brActionGet() : object
    {
        $filteredNl2brText = $this->filter->parse($this->nl2brText, ["nl2br"]);
        $data = [
            "title" => "Textfilter - Links",
            "nl2brText" => $this->nl2brText,
            "filteredNl2brText" => $filteredNl2brText
        ];

        $this->app->page->add("filter/nl2br", $data);

        return $this->app->page->render($data);
    }
}
