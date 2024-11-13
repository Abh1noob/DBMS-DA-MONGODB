<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client('<mongo-uri>');

$accountsCollection = $client->bank->accounts;
$transfersCollection = $client->bank->transfers;



$senderAccountId = 'MDB829001338';
$receiverAccountId = 'MDB829001340';
$transferAmount = new MongoDB\BSON\Decimal128('10000.00');
$transferId = 'TR218721873';



$senderDoc = $accountsCollection->findOne(['account_id' => $senderAccountId]);
$receiverDoc = $accountsCollection->findOne(['account_id' => $receiverAccountId]);

printf(
    "%s, Balance: $%.2f\n%s, Balance: $%.2f\n",
    $senderDoc['account_holder'],
    (float) (string) $senderDoc['balance'],
    $receiverDoc['account_holder'],
    (float) (string) $receiverDoc['balance']
);

$session = $client->startSession();

try {
    $session->startTransaction();



    $accountsCollection->updateOne(
        ['account_id' => $senderAccountId],
        ['$inc' => ['balance' => new MongoDB\BSON\Decimal128('-100.00')], '$push' => ['transfers_complete' => $transferId]],
        ['session' => $session]
    );



    $accountsCollection->updateOne(
        ['account_id' => $receiverAccountId],
        ['$inc' => ['balance' => $transferAmount], '$push' => ['transfers_complete' => $transferId]],
        ['session' => $session]
    );



    $transferDoc = [
        'transferId' => $transferId,
        'to_account' => $receiverAccountId,
        'from_account' => $senderAccountId,
        'amount' => $transferAmount,
    ];

    $transfersCollection->insertOne($transferDoc, ['session' => $session]);



    $session->commitTransaction();
} catch (Exception $e) {


    $session->abortTransaction();
    echo 'Caught exception: ', $e->getMessage(), "\n";
    exit();
}



$senderDoc = $accountsCollection->findOne(['account_id' => $senderAccountId]);
$receiverDoc = $accountsCollection->findOne(['account_id' => $receiverAccountId]);
$transferDetails = $transfersCollection->findOne(["transferId" => $transferId]);

printf(
    "%s, Sent from: %s, Received by: %s, Amount transferred: $%.2f\n",
    $transferDetails['transferId'],
    $transferDetails['from_account'],
    $transferDetails['to_account'],
    (float) (string) $transferDetails['amount']
);

printf(
    "%s, Balance: $%.2f\n%s, Balance: $%.2f\n",
    $senderDoc['account_holder'],
    (float) (string) $senderDoc['balance'],
    $receiverDoc['account_holder'],
    (float) (string) $receiverDoc['balance']
);
