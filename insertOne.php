<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client('<mongo-uri>');

$accountsCollection = $client->bank->accounts;

$sampleAccount = [
    'account_holder' => 'Linus Torvalds',
    'account_id' => 'MDB829001337',
    'account_type' => 'checking',
    'balance' => new MongoDB\BSON\Decimal128('503524.34')
];

$insertOneResult = $accountsCollection->insertOne($sampleAccount);

printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());
var_dump($insertOneResult->getInsertedId());
