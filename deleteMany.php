<?php 

require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client('<mongo-uri>');

$accountsCollection = $client->bank->accounts;

$filter = ['balance' => ['$lt' => new MongoDB\BSON\Decimal128('650000')]];

$deleteManyResult = $accountsCollection->deleteMany($filter);

printf("Deleted %d document(s)\n", $deleteManyResult->getDeletedCount());