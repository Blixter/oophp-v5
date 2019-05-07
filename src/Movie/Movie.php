<?php
namespace Blixter\Movie;

/**
 * A class for the movie database
 */
class Movie
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
     * Fetch all movies from the database
     *
     * @return object resultset.
     */
    public function getAllMovies()
    {   
        $sql = "SELECT * FROM movie;";
        $this->db->connect();
        $res = $this->db->executeFetchAll($sql);
        return $res;
    }

    /**
     * Fetch all movies from the database sorted,
     * @param int   $orderBy Which column to sort on.
     * @param int   $order How to sort, DESC OR ASC.
     * @param int   $hits How many hits per page.
     * @param int   $offset Number of rows to skip. 
     *
     * @return object resultset.
     */
    public function getAllMoviesSorted($orderBy, $order, $hits, $offset)
    {   
        $this->db->connect();
        $sql = "SELECT * FROM movie ORDER BY $orderBy $order LIMIT $hits OFFSET $offset;";
        $res = $this->db->executeFetchAll($sql);
        return $res;
    }

    /**
     * Search movies on year released
     * @param int   $year1 Min year
     * @param int   $year2 Max year
     *
     * @return object resultset.
     */
    public function searchYearMovies($year1, $year2)
    {   
        $this->db->connect();

        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            return $this->db->executeFetchAll($sql, [$year1, $year2]);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            return $this->db->executeFetchAll($sql, [$year1]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            return $this->db->executeFetchAll($sql, [$year2]);
        }
    }

    /**
     * Search movies on movie title.
     *
     * @return object resultset.
     */
    public function searchTitleMovies($searchTitle)
    {   
        $this->db->connect();
        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        return $this->db->executeFetchAll($sql, [$searchTitle]);
    }


    /**
     * Get number of pages for incoming hit.
     * @param int $hits Number of hits
     * 
     * @return int Max number of pages.
     *
     */
    public function getMaxPages($hits)
    {
        $this->db->connect();
        $sql = "SELECT COUNT(id) AS max FROM movie;";
        $res = $this->db->executeFetch($sql);
        $max = ceil($res->max / $hits);
        return $max;
    }

    /**
     * Delete row from table.
     * @param int $id of the row.
     *
     * @return void
     */
    public function deleteRow($id)
    {   
        $this->db->connect();
        $sql = "DELETE FROM movie WHERE id = ?;";
        $this->db->execute($sql, [$id]);
    }

    /**
     * Add row to table.
     *
     * @return $id of the row.
     */
    public function addRow()
    {   
        $this->db->connect();
        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $this->db->execute($sql, ["A title", 2017, "noimage.png"]);
        return $this->db->lastInsertId();
    }

    /**
     * Add row to table.
     * @param int $movieId id of the movie
     * @param str $movieTitle Title of the movie
     * @param int $movieYear Realease date of the movie
     * @param str $movieImage Imagepath for the thumb-img.
     *
     * @return void
     */
    public function updateRow($movieId, $movieTitle, $movieYear, $movieImage)
    {   
        $this->db->connect();
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $this->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
    }

    /**
     * Add row to table.
     * @param int $movieId id of the movie
     *
     * @return object resultset
     */
    public function getMovieById($movieId)
    {   
        $this->db->connect();
        $sql = "SELECT * FROM movie where id = $movieId;";
        $res = $this->db->executeFetch($sql);
        return $res;
    }


    /**
     * Reset database
     *
     * @return void
     */
    public function resetDatabase()
    {
    // Restore the database to its original settings
        $this->db->connect();
        $sql1 = "DELETE FROM `movie`;";
        $sql2 = "INSERT INTO `movie` (`title`, `year`, `image`) VALUES
            ('Pulp fiction', 1994, 'pulp-fiction.jpg'),
            ('American Pie', 1999, 'american-pie.jpg'),
            ('Pokémon The Movie 2000', 1999, 'pokemon.jpg'),  
            ('Kopps', 2003, 'kopps.jpg'),
            ('From Dusk Till Dawn', 1996, 'from-dusk-till-dawn.jpg')
        ;";
        $this->db->execute($sql1);
        $this->db->execute($sql2);
    }
}
