<?php
namespace Blixter\Movie;

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
class MovieController implements AppInjectableInterface
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
        // Initalise a new movie object, with the movie-database as argument.
        $this->movie = new Movie($this->app->db);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/show
     * 
     * @return object
     *
     */
    public function showActionGet() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;

        // Get number of hits per page
        $hits = $request->getGet('hits', 4);
        if (!(is_numeric($hits) && $hits > 0 && $hits <= 8)) {
            // Redirect back to this route if out of bounds.
            $response->redirect('movie/show');
        }

        $max = $this->movie->getMaxPages($hits);

        // Get current page
        $page = $request->getGet("page", 1);
        if (!(is_numeric($hits) && $page > 0 && $page <= $max)) {
            // Redirect back to this route if out of bounds.
            $response->redirect('movie/show');
        }
        $offset = $hits * ($page - 1);

        // Only these values are valid
        $columns = ["id", "title", "year", "image"];
        $orders = ["asc", "desc"];

        $orderBy = $request->getGet("orderby") ?: "id";
        $order = $request->getGet("order") ?: "asc";

        // Incoming matches valid value sets
        if (in_array($orderBy, $columns) && in_array($order, $orders)) {
            $res = $this->movie->getAllMoviesSorted($orderBy, $order, $hits, $offset);
        } else {
            // Redirect back to this route if not valid value sets
            $response->redirect('movie/show');
        }
        
        $data = [
            "title"     => "Filmdatabas",
            "resultset" => $res ?? null,
            "max"       => $max,
            "page"      => $page
        ];

        $this->app->page->add("movie/header", $data);     
        $this->app->page->add("movie/show-all-paginate", $data);

        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/searchtitle
     * 
     * @return object
     */
    public function searchtitleActionGet() : object
    {
        // Search for the title
        $page = $this->app->page;
        $request = $this->app->request;
        $title = "Sök på titeln i databasen";
        $searchTitle = $request->getGet("searchTitle");
        
        $data = [
            "title" => $title,
            "searchTitle" => $searchTitle
        ];
        
        $page->add("movie/header", $data);

        if ($searchTitle) {
            $res = $this->movie->searchTitleMovies($searchTitle);
            $data["resultset"] = $res;
            $page->add("movie/show-all", $data);
        }
        $page->add("movie/search-title", $data);
        return $page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/searchyear
     * 
     * @return object
     */
    public function searchyearActionGet() : object
    {
        // Search for the year
        $page = $this->app->page;
        $request = $this->app->request;
        
        $title = "Sök på årtal i databasen";
       
        $year1 = $request->getGet("year1");
        $year2 = $request->getGet("year2");
        
        $res = $this->movie->searchYearMovies($year1, $year2);
        
        $data = [
            "title" => $title,
            "resultset" => $res ?? null
        ];
        
        $page->add("movie/header", $data);
        $page->add("movie/show-all", $data);
        $page->add("movie/search-year", $data);
        return $page->render($data);
    }


    /**
     * This method is handler for the route:
     * GET/POST mountpoint/select
     * @return object
     */
    public function selectAction() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;

        $movieId = $request->getPost('movieId');

        $data = [
            "title" => "Välj film eller lägg till en ny",
        ];

        if ($request->getPost('doDelete')) {
            $this->movie->deleteRow($movieId);
            $response->redirect('movie/select');
        } elseif ($request->getPost("doAdd")) {
            $movieId = $this->movie->addRow();
            $response->redirect("movie/edit?movieId=$movieId");
        } elseif ($request->getPost("doEdit") && is_numeric($movieId)) {
            $response->redirect("movie/edit?movieId=$movieId");
        }
        $this->app->page->add('movie/header', $data);
        $data['movies'] = $this->movie->getAllMovies();
        $this->app->page->add('movie/movie-select', $data);
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET/POST mountpoint/edit
     * @return object
     */
    public function editAction() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;

        $movieId = $request->getGet('movieId');

        $data = [
            "title" => "Redigera film",
        ];

        if ($request->getPost('doSave')) {
            $movieTitle = $request->getPost("movieTitle");
            $movieYear = $request->getPost("movieYear");
            $movieImage = $request->getPost("movieImage");
            $this->movie->updateRow($movieId, $movieTitle, $movieYear, $movieImage);
            $response->redirect("movie/edit?movieId=$movieId");
        }
        $this->app->page->add('movie/header', $data);
        $data["movie"] = $this->movie->getMovieById($movieId);
        $this->app->page->add('movie/movie-edit', $data);
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET/POST mountpoint/reset
     * @return object
     */
    public function resetAction() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;

        $data = [
            "title" => "Återställ databasen",
        ];

        if ($request->getPost('reset')) {
            $this->movie->resetDatabase();
            $response->redirect("movie/show");
        }

        $this->app->page->add('movie/header', $data);
        $this->app->page->add('movie/reset', $data);
        return $this->app->page->render($data);
    }
}
