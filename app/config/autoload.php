<?php

$pluginsAutoLoad = [
    "sweetalert" => [
        "js" => ["sweetalert2.all"],
        "css" => null,
    ],
    "mascara" => [
        "js" => ["mascara"],
        "css" => null,
    ],
    "alertify" => [
        "js" => ["js/alertify"],
        "css" => ["css/alertify"]
    ],
    "dropify" => [
        "js" => ["js/dropify.min"],
        "css" => ["css/dropify.min"],
    ],
];

// Salva como constant
defined("PLGUINS_AUTOLOAD") OR define("PLGUINS_AUTOLOAD", serialize($pluginsAutoLoad));