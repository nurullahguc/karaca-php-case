<?php
require 'KaracaProducts.php';
Header('Content-Type: text/xml');

$username = @$_GET['username'];
$password = @$_GET['password'];

$karacaProducts = new KaracaProducts();

$xml = new SimpleXMLElement('<xml/>');
$resultChild = $xml->addChild('result');

if ($username == null || $password == null) {
    $resultChild->addChild('statusCode', 401);
    $resultChild->addChild('description', 'Please provide username and password!');
} else {

    $users = json_decode(file_get_contents('users.json'));
    foreach ($users as $key) {
        if ($key->username == $username and $key->password == $password) {
            $karacaProducts->setUser($key);
            return print ($karacaProducts->listProducts()->asXML());
        }
    }
    $resultChild->addChild('statusCode', 401);
    $resultChild->addChild('description', 'Username or password is wrong!');
}

print ($xml->asXML());
?>