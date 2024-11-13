<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client('<mongo-uri>');

$accountsCollection = $client->bank->accounts;

$filter = ['_id' => new MongoDB\BSON\ObjectID('6733915fb7478549450f00b2')];

$deleteOneResult = $accountsCollection->deleteOne($filter);

printf("Deleted %d document(s)\n", $deleteOneResult->getDeletedCount());

printf("Searching for target document after delete:\n");
var_dump($accountsCollection->findOne($filter));