<?php
declare(strict_types=1);
use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\auth\AuthnProvider;


require_once 'vendor/autoload.php';

session_start(); 

iutnc\deefy\repository\DeefyRepository::setConfig( 'db.config.ini' );

$action = $_GET['action'] ?? 'default';

$dispatcher = new Dispatcher($action);
$dispatcher->run();






