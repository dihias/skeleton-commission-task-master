<?php

require_once 'vendor/autoload.php';

use Feecal\Entities\Operation;
use Feecal\Repositories\InMemoryOperationRepository as OperationRepository;
use Feecal\Services\Commissions\CommissionCalculator;
use Feecal\Services\Readers\CsvReader;


$path = $argv[1];

$repository = new OperationRepository();

$reader = new CsvReader($path);
$data = $reader->getData();

$id = 1;
foreach ($data as $row) {
    $operation = new Operation();
    $operation->setId($id++);
    $operation->setDate($row[0]);
    $operation->setPersonId((int) $row[1]);
    $operation->setPersonType($row[2]);
    $operation->setName($row[3]);
    $operation->setAmount($row[4]);
    $operation->setCurrency($row[5]);

    $repository->add($operation);
}

$calculator = new CommissionCalculator($repository);
$results = $calculator->calculate();

foreach ($results as $result) {
   echo $result."\n";
    
}