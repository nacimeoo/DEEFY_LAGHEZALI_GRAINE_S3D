<?php
declare(strict_types=1);
use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\repository\DeefyRepository;


require_once 'vendor/autoload.php';

session_start();

DeefyRepository::setConfig( 'C:/xampp/config/db.config.ini' );

$action = $_GET['action'] ?? 'default';

$dispatcher = new Dispatcher($action);
$dispatcher->run();






