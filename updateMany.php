<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client('<mongo-uri>');


$accountsCollection = $client->bank->accounts;

$filter = ['account_type' => 'checking'];

$setField = ['$set' => ['minimum_balance' => new MongoDB\BSON\Decimal128('100')]];

$updateManyResult = $accountsCollection->updateMany($filter, $setField);

printf("Matched %d document(s)\n", $updateManyResult->getMatchedCount());
printf("Modified %d document(s)\n", $updateManyResult->getModifiedCount());

$updatedExample = $accountsCollection->findOne($filter);

var_dump($updatedExample);
