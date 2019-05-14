<?php
namespace Blixter\Content;

/**
 * A class for the Content database
 */
class Content
{

    /** @var object $db    Anax Database object */
    protected $db;

    /**
     * Constructor to create a database..
     * @param obj   $db A database object
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Fetch all pages from the database
     *
     * @return object resultset.
     */
    public function getAllPages()
    {   
        $sql = <<<EOD
SELECT
    *,
    CASE 
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE type=?
;
EOD;
        $this->db->connect();
        $res = $this->db->executeFetchAll($sql, ["page"]);
        return $res;
    }

    /**
     * Fetch all blog posts from the database
     *
     * @return object resultset.
     */
    public function getAllPosts()
    {   
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;
        $this->db->connect();
        $res = $this->db->executeFetchAll($sql, ["post"]);
        return $res;
    }

    /**
     * Fetch a blog post
     * @param str $slug of the row.
     *
     * @return object resultset with the data filtered.
     */
    public function getPost($slug)
    {   
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE 
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
        $this->db->connect();
        $res = $this->db->executeFetch($sql, [$slug, "post"]);

        $filter = new \Blixter\TextFilter\MyTextFilter();
        $res->data = $filter->parse($res->data, $res->filter);

        return $res;
    }

    /**
     * Fetch a page
     * @param str $path of the row.
     *
     * @return object resultset with the data filtered.
     */
    public function getPage($path)
    {   
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
        $this->db->connect();
        $res = $this->db->executeFetch($sql, [$path, "page"]);

        $filter = new \Blixter\TextFilter\MyTextFilter();
        $res->data = $filter->parse($res->data, $res->filter);

        return $res;
    }

    /**
     * Fetch all content from database
     *
     * @return object resultset.
     */
    public function getAllContent()
    {   
        $this->db->connect();
        $sql = "SELECT * FROM content;";
        $res = $this->db->executeFetchAll($sql);
        return $res;
    }

    /**
     * Get content by Id
     * @param int $id of the row.
     * @return object resultset.
     */
    public function getContentById($id)
    {   
        $this->db->connect();
        $sql = "SELECT * FROM content WHERE id = ?;";
        return $this->db->executeFetch($sql, [$id]);
    }

    /**
     * Soft delete row from table.
     * @param int $id of the row.
     *
     * @return void
     */
    public function deleteRow($id)
    {   
        $this->db->connect();
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $this->db->execute($sql, [$id]);
    }

    /**
     * Add content to table;
     *
     * @return $id of the row.
     */
    public function addRow($title)
    {   
        $this->db->connect();
        $sql = "INSERT INTO content (title) VALUES (?);";
        $this->db->execute($sql, [$title]);
        return $this->db->lastInsertId();
    }

    /**
     * Update row in table.
     * @param array $params with update. 
     *
     * @return void
     */
    public function updateRow($params)
    {   
        $this->db->connect();
        $sql = "UPDATE content SET title=?, data=?, type=?, path=?, slug=?, filter=?, published=? WHERE id = ?;";
        $this->db->execute($sql, $params);
    }

    /**
     * Reset database
     *
     * @return void
     */
    public function resetDatabase($database)
    {
        // Restore the database to its original settings

        $dbConfig = $database["config"];

        $file   = "../sql/content/setup.sql";
        $mysql  = "/usr/bin/mysql";

        // Extract hostname and databasename from dsn
        $dsnDetail = [];
        preg_match("/mysql:host=(.+);dbname=([^;.]+)/", $dbConfig["dsn"], $dsnDetail);
        $host = $dsnDetail[1];
        $database = $dsnDetail[2];
        $username = $dbConfig["username"];
        $password = $dbConfig["password"];

        $command = "$mysql -h{$host} -u{$username} -p{$password} $database < $file 2>&1";
        $output = [];
        $status = null;
        exec($command, $output, $status);
        $output = "The command exit status was $status."
            . "<br>The output from the command was:</p><pre>"
            . print_r($output, 1);

        return $output;
    }

    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     * 
     * @return str the formatted slug.
     */
    public function slugify($str)
    {   
        $str = mb_strtolower(trim($str));
        $str = str_replace(['å','ä'], 'a', $str);
        $str = str_replace('ö', 'o', $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }

    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     * 
     * @return str the formatted slug.
     */
    public function uniqueSlug($str)
    {   
        $slugs = [];

        $str = mb_strtolower(trim($str));
        $str = str_replace(['å','ä'], 'a', $str);
        $str = str_replace('ö', 'o', $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        
        $this->db->connect();
        $sql = "SELECT slug FROM content WHERE slug LIKE ?";
        $res = $this->db->executeFetchAll($sql, [$str . "%"]);

        // Add all slugs with same prefix to array $slugs
        foreach ($res as $row) {
            array_push($slugs, $row->slug);
        }
        
        // If there is a slug with the same name
        if (sizeof($res) !== 0 && in_array($str, $slugs)) {
            $max = 1;

            // $max will increment until finding an unique slug
            while (in_array(($str . '-' . $max ), $slugs)) {
                ++$max;
            };

            // Adding the number to the slug making it unique
            $str .= '-' . $max;
        }
        
        return $str;
    }

    /**
     * Create a path of a string, to be used as url.
     *
     * @param string $str the string to format as path.
     * 
     * @return str the formatted path.
     */
    public function uniquePath($str)
    {   
        $pathes = [];

        $str = mb_strtolower(trim($str));
        $str = str_replace(['å','ä'], 'a', $str);
        $str = str_replace('ö', 'o', $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        
        $this->db->connect();
        $sql = "SELECT path FROM content WHERE path LIKE ?";
        $res = $this->db->executeFetchAll($sql, [$str . "%"]);

        // Add all path with same prefix to array $pathes
        foreach ($res as $row) {
            array_push($pathes, $row->path);
        }
        
        // If there is a path with the same name
        if (sizeof($res) !== 0 && in_array($str, $pathes)) {
            $max = 1;

            // $max will increment until finding an unique path
            while (in_array(($str . '-' . $max ), $pathes)) {
                ++$max;
            };

            // Adding the number to the path making it unique
            $str .= '-' . $max;
        }
        return $str;
    }

    /**
     * Create a path of a string, to be used as url.
     *
     * @param string $str the string to format as path.
     * 
     * @return str the formatted path.
     */
    public function login($username, $password)
    {   
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?;";
        $this->db->connect();
        $res = $this->db->executeFetch($sql, [$username, $password]);

        if ($res) {
            return true;
        }
        return false;
    }
}
