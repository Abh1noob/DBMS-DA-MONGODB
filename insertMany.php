<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client('<mongo-uri>');

$accountsCollection = $client->bank->accounts;

$sampleAccounts = [
    [
        'account_holder' => 'Abhinav Ganeshan',
        'account_id' => 'MDB829001337',
        'account_type' => 'checking',
        'balance' => new MongoDB\BSON\Decimal128('503524.34')
    ],
    [
        'account_holder' => 'Ganeshan Kalpathy',
        'account_id' => 'MDB829001338',
        'account_type' => 'saving',
        'balance' => new MongoDB\BSON\Decimal128('5030524.34')
    ],
    [
        'account_holder' => 'Akshitha Ganeshan',
        'account_id' => 'MDB829001339',
        'account_type' => 'current',
        'balance' => new MongoDB\BSON\Decimal128('603240.34')
    ],
    [
        'account_holder' => 'Rema Narayanan',
        'account_id' => 'MDB829001340',
        'account_type' => 'checking',
        'balance' => new MongoDB\BSON\Decimal128('1023524.34')
    ]
];

$insertOneResult = $accountsCollection->insertMany($sampleAccounts);

printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());
var_dump($insertOneResult->getInsertedIds());
