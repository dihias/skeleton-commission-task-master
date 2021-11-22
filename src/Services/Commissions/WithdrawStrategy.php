<?php
declare(strict_types=1);


namespace Feecal\Services\Commissions;

use Feecal\Entities\Operation;
use Feecal\Repositories\OperationRepository;
use Feecal\Services\Commissions\CommissionStrategy;
use Feecal\Services\CurrencyConverter;

class WithdrawStrategy extends CommissionStrategy
{
    const COMMISSION_PERCENT = 0.3;
    const COMMISSION_MIN_business = 0.50;
    const TIMES_PER_WEEK = 3;
    const AMOUNT_PER_WEEK = 1000;

    private $repository;

    public function __construct(Operation $operation, OperationRepository $repository)
    {
        parent::__construct($operation);
        $this->repository = $repository;
    }

    public function calculate(): float
    {
        $person_type = $this->operation->getPersonType();

        if ($person_type == 'private') {
            $commission = $this->calculateForprivatePerson();
        } else if ($person_type == 'business') {
            $commission = $this->calculateForbusinessPerson();
        }

        return (float) $commission;
    }

    protected function calculateForprivatePerson(): float
    {
        $id = $this->operation->getId();
        $person_id = $this->operation->getPersonId();
        $current_date = $this->operation->getDate();

        $current_amount = CurrencyConverter::convertToEur($this->operation->getAmount(), $this->operation->getCurrency());

        $person_operations = $this->repository->getPersonWithdrawOperationsFromSameWeek($person_id, $current_date);

        $times_per_week = 0;
        $amount_per_week = 0;
        $discount_id = null;

        foreach ($person_operations as $operation) {
            $times_per_week++;
            if ($times_per_week <= self::TIMES_PER_WEEK) {
                $amount_per_week += CurrencyConverter::convertToEur($operation->getAmount(), $operation->getCurrency());
            }

            if ($amount_per_week >= self::AMOUNT_PER_WEEK) {
                $discount_id = $operation->getId();
                break;
            }
        }

        if (!empty($discount_id)) {

            if ($id == $discount_id) {
                $current_amount = $amount_per_week - self::AMOUNT_PER_WEEK;
            } else if ($id < $discount_id) {
                $current_amount = 0;
            }

        } else {
            $current_amount = 0;
        }

        $commission = $current_amount * self::COMMISSION_PERCENT / 100;

        $converted = CurrencyConverter::convertEur($commission, $this->operation->getCurrency());

        return $converted;
    }

    protected function calculateForbusinessPerson(): float
    {
        $commission = $this->operation->getAmount() * self::COMMISSION_MIN_business / 100;

        

        return $commission;
    }
}
