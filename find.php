<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client('<mongo-uri>');


$accountsCollection = $client->bank->accounts;

$filter = ['balance' => ['$gt' => new MongoDB\BSON\Decimal128('550000')]];

$cursor = $accountsCollection->find($filter);

foreach ($cursor as $account) {
  var_dump($account);
}