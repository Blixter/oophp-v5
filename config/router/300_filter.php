<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Filter controller",
            "mount" => "filter",
            "handler" => "\Blixter\TextFilter\FilterController",
        ],
    ]
];
