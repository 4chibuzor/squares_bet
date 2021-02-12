<?php
try {
  require_once __DIR__ . "/config/config.php";
  require_once __DIR__ . "/vendor/autoload.php";
  $route =  strtok($_SERVER['REQUEST_URI'], '?') ?? '/derrick/';

  $derrickRouter = new \Controllers\DerrickRouter(
    $route,
    $_SERVER['REQUEST_METHOD'],
    new \Controllers\DerrickRoutes()
  );
  $derrickRouter->runApp();
} catch (Exception $e) {
  $title = "An error has occurred";
  $output = "Error " . $e->getMessage() . " in " . $e->getFile() . " on Line " . $e->getLine();
}
