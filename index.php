<?php
require 'bootstrap.php';

try {
    $dbPath = __DIR__.'/data/database.sqlite';
    $dbh = new PDO('sqlite:'.$dbPath);
} catch(PDOException $e) {
    die('Panic! '.$e->getMessage());
}

// create a request object to help us
use Symfony\Component\HttpFoundation\Request;
$request = Request::createFromGlobals();

$uri = $request->getPathInfo();

if ($uri == '/' || $uri == '') {

    echo '<h1>Welcome to PHP Santa</h1>';
    echo sprintf('<a href="/letters">Read the letters</a>');
    if ($name = $request->query->get('name')) {
        echo sprintf('<p>Oh, and hello %s!</p>', $_GET['name']);
    }

} elseif ($uri == '/letters') {

    $sql = 'SELECT * FROM php_santa_letters';
    echo '<h1>Read the letters to PHP Santa</h1>';
    echo '<ul>';
    foreach ($dbh->query($sql) as $row) {
        echo sprintf('<li>%s - dated %s</li>', $row['content'], $row['received_at']);
    }
    echo '</ul>';

} else {
    header("HTTP/1.1 404 Not Found");
    echo '<h1>404 Page not Found</h1>';
    echo '<p>This is most certainly *not* an xmas miracle</p>';
}