<?php
/**
 * Load MovieController as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Movie controller",
            "mount" => "movie",
            "handler" => "\Blixter\Movie\MovieController",
        ],
    ]
];
