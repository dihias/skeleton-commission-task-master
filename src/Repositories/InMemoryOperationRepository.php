<?php

namespace Feecal\Repositories;

use Feecal\Entities\Operation;
use Feecal\Repositories\OperationRepository;

class InMemoryOperationRepository implements OperationRepository
{
    protected $operations;

    public function add(Operation $operation)
    {
        $this->operations[] = $operation;
    }

    public function getAll(): array
    {
        return $this->operations;
    }

    public function getPersonWithdrawOperationsFromSameWeek(int $person_id, $date): array
    {
        $operations = [];

        $current_date = new \DateTime($date);
        $current_week = $current_date->format('W');

        foreach ($this->operations as $operation) {

            $operation_date = new \DateTime($operation->getDate());
            $operation_week = $operation_date->format('W');
           
            if ($operation->getPersonId() == $person_id && $operation->getName() == Operation::withdraw) {

                if ($current_week == $operation_week && abs($current_date->diff($operation_date)->format('%R%a'))<=7) {
                    $operations[] = $operation;
                } else if ($current_week < $operation_week) {
                    break;
                }
            }
        }

        return $operations;
    }
}
