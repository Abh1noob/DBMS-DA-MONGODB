<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client('<mongo-uri>');

$accountsCollection = $client->bank->accounts;

$filter = ['_id' => new MongoDB\BSON\ObjectId('673397994cd6adfaf90f1672')];

$result = $accountsCollection->findOne($filter);

var_dump($result);