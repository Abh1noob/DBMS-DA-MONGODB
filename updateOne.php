<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client('<mongo-uri>');

$accountsCollection = $client->bank->accounts;

$filter = ['_id' => new MongoDB\BSON\ObjectId('6733915fb7478549450f00b2')];

$addToBalance = [
    '$inc' => [
        'balance' => new MongoDB\BSON\Decimal128('100'),
    ]
];

var_dump($accountsCollection->findOne($filter));

$updateOneResult = $accountsCollection->updateOne($filter, $addToBalance);

printf("Matched %d document(s)\n", $updateOneResult->getMatchedCount());
printf("Modified %d document(s)\n", $updateOneResult->getModifiedCount());

$updatedExample = $accountsCollection->findOne($filter);

var_dump($updatedExample);