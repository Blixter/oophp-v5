<?php
namespace Blixter\Content;

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
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * 
 */
class ContentController implements AppInjectableInterface
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
        $this->content = new Content($this->app->db);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/
     * GET mountpoint/index
     * 
     * @return object
     *
     */
    public function indexActionGet() : object
    {
        $page = $this->app->page;
        $res = $this->content->getAllContent();

        $data = [
            "title"     => "Visa allt innehåll",
            "resultset" => $res
        ];

        $this->app->page->add("content/header", $data);     
        $this->app->page->add("content/show-all", $data);

        return $page->render($data);
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

        $session = $this->app->session;
        if (!$session->get("loggedin")) {
            $response->redirect("content/login");
        };

        $contentId = $request->getGet('contentId') ?: $request->getGet('id');
        if (!is_numeric($contentId)) {
            $response->redirect("content/show-all");
        }
        $data = [
            "title" => "Redigera",
        ];

        if ($request->getPost('doDelete')) {
            $response->redirect("content/delete?id=" . $contentId);
        }
        
        if ($request->getPost('doSave')) {
            $post = $request->getPost();

            $params = [
                "contentTitle" => $post["contentTitle"] ?? null,
                "contentData" => $post["contentData"] ?? null,
                "contentType" => $post["contentType"] ?? null
            ];

            if ($params["contentType"] == "post") {
                $params["contentPath"] = null;
            } else {
                $params["contentPath"] = $this->content->uniquePath($params["contentTitle"]);
            }

            if ($params["contentType"] == "page") {
                $params["contentSlug"] = null;
            } else {
                $params["contentSlug"] = $this->content->uniqueSlug($params["contentTitle"]);
            }

            $params["contentFilter"] = implode(",", $post["contentFilter"]);

            $params["contentPublish"] = $post["contentPublish"] ?? null;

            $params["contentId"] = $post["contentId"] ?? null;

            $this->content->updateRow($params);
            $response->redirect("content/edit?id=" . $contentId);
        }


        $data["content"] = $this->content->getContentById($contentId);
        $this->app->page->add('content/header', $data);
        $this->app->page->add('content/edit', $data);
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET/POST mountpoint/create
     * @return object
     */
    public function createAction() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;

        $session = $this->app->session;
        if (!$session->get("loggedin")) {
            $response->redirect("content/login");
        };

        $create = $request->getPost('doCreate') ?? null;

        
        if (isset($create)) {
            $title = $request->getPost('contentTitle');
            $contentId = $this->content->addRow($title);
            $response->redirect("content/edit?contentId=$contentId");
        }

        $data = [
            "title" => "Skapa innehåll",
            "getPost" => $request->getPost('doCreate')
        ];

        $this->app->page->add('content/header', $data);
        $this->app->page->add('content/create', $data);
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

        $session = $this->app->session;
        if (!$session->get("loggedin")) {
            $response->redirect("content/login");
        };

        $dbConfig = $this->app->configuration->load("database");

        if ($request->getPost('reset')) {
            $output = $this->content->resetDatabase($dbConfig);
        }

        $data = [
            "title" => "Återställ databasen",
            "output" => $output ?? null
        ];

        $this->app->page->add('content/header', $data);
        $this->app->page->add('content/reset', $data);
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET/POST mountpoint/delete
     * @return object
     */
    public function deleteAction() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;

        $session = $this->app->session;
        if (!$session->get("loggedin")) {
            $response->redirect("content/login");
        };

        $delete = $request->getPost('doDelete') ?? null;
        
        $contentId = $request->getGet('contentId') ?: $request->getGet('id');
        if (!is_numeric($contentId)) {
            $response->redirect("content/show-all");
        }

        if (isset($delete)) {
            $this->content->deleteRow($contentId);
            $response->redirect("content/admin");
        }

        $data = [
            "title" => "Ta bort innehåll"
        ];
        $data["content"] = $this->content->getContentById($contentId);
        $this->app->page->add('content/header', $data);
        $this->app->page->add('content/delete', $data);
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/admin
     * 
     * @return object
     *
     */
    public function adminActionGet() : object
    {
        $page = $this->app->page;
        $response = $this->app->response;
        
        $session = $this->app->session;
        if (!$session->get("loggedin")) {
            $response->redirect("content/login");
        };
        $res = $this->content->getAllContent();

        $data = [
            "title"     => "Admin",
            "resultset" => $res
        ];

        $this->app->page->add("content/header", $data);     
        $this->app->page->add("content/admin", $data);

        return $page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/blog
     * 
     * @return object
     *
     */
    public function blogActionGet() : object
    {
        $page = $this->app->page;
        $request = $this->app->request;

        $slug =  $request->getGet("post") ?? null;

        $data = [
            "title"     => "Blogg"
        ];
        
        $this->app->page->add("content/header", $data);

        if ($slug) {
            $res = $this->content->getPost($slug);
            $data["content"] = $res;
            $page->add("content/blogpost", $data);
        } else {
            $res = $this->content->getAllPosts();
            $data["resultset"] = $res;
            $page->add("content/blog", $data);
        }

        return $page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/pages
     * 
     * @return object
     *
     */
    public function pagesActionGet() : object
    {
        $page = $this->app->page;
        $request = $this->app->request;
        $path =  $request->getGet("path") ?? null;

        $data = [
            "title"     => "Sidor"
        ];

        $this->app->page->add("content/header", $data);

        if ($path) {
            $res = $this->content->getPage($path);
            $data["content"] = $res;
            $page->add("content/page", $data);
        } else {
            $res = $this->content->getAllPages();
            $data["resultset"] = $res;
            $page->add("content/pages", $data);
        }

        return $page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/login
     * 
     * @return object
     *
     */
    public function loginAction() : object
    {
        $page = $this->app->page;
        $request = $this->app->request;
        $session = $this->app->session;
        $response = $this->app->response;

        if ($request->getPost("login")) {
            $username = $request->getPost("username");
            $password = $request->getPost("password");
            if ($this->content->login($username, $password)) {
                $session->set("loggedin", $username);
                $response->redirect("content/admin");
            } else {
                $message = "Fel användarnnamn eller lösenord!";
            }
        }

        $data = [
            "title"     => "Logga in",
            "message"   => $message ?? null
        ];

        $page->add("content/header", $data);
        $page->add("content/login", $data);
        return $page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/login
     * 
     * @return object
     *
     */
    public function logoutAction() : object
    {
        $page = $this->app->page;
        $request = $this->app->request;
        $session = $this->app->session;
        $response = $this->app->response;
        $user = $session->get("loggedin");

        $data = [
            "title"     => "Logga ut",
            "user"      => $user 
        ];

        if ($request->getPost("logout")) {
            $session->delete("loggedin");
            $response->redirect("content/login");
        }

        $page->add("content/header", $data);
        $page->add("content/logout", $data);
        return $page->render($data);
    }
}
