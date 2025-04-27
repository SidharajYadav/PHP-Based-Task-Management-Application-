<?php
require_once __DIR__ . '/../controllers/ApiController.php';

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

$apiController = new ApiController();
$apiController->handleRequest();
?>