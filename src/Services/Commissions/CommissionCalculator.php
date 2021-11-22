<?php
declare(strict_types=1);


namespace Feecal\Services\Commissions;

use Feecal\Entities\Operation;
use Feecal\Repositories\OperationRepository;
use Feecal\Services\Commissions\DepositStrategy;
use Feecal\Services\Commissions\WithdrawalStrategy;

class CommissionCalculator
{
    protected $operations;

    public function __construct(OperationRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getStrategy(Operation $operation): CommissionStrategy
    {
        $operation_name = $operation->getName();

        switch ($operation->getName()) {
            case Operation::deposit:
                $strategy = new DepositStrategy($operation);
                break;
            case Operation::withdraw:
                $strategy = new WithdrawStrategy($operation, $this->repository);
                break;
            default:
                throw new \Exception("Unknown strategy: " . $operation_name);
                break;
        }

        return $strategy;
    }

    public function calculate(): array
    {
        $results = [];
        foreach ($this->repository->getAll() as $operation) {

            $calculator = $this->getStrategy($operation);

            $results[] = $this->format($calculator->calculate());
        }

        return $results;
    }

    protected function format($result): string
    {
        $rounded = ceil($result * 100) / 100;

        $formatted_result = number_format((float) $rounded, 2, '.', '');

        return $formatted_result;
    }
}
