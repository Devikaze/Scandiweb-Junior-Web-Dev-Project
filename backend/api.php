<?php

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type"); 

require __DIR__ . '/vendor/autoload.php';
require_once 'db.php';

use Devikaze\Backend\ProductController;

$db = connectToDatabase();

$productController = new ProductController($db);
$productController->handleRequest();

closeDatabaseConnection($db);