<?php
declare(strict_types=1);


namespace Feecal\Services\Commissions;

use Feecal\Entities\Operation;
use Feecal\Services\Commissions\CommissionStrategy;

class DepositStrategy extends CommissionStrategy
{
    protected $operation;

    const COMMISSION_PERCENT = 0.03;
    

    public function calculate(): float
    {
        $commission = $this->operation->getAmount() * self::COMMISSION_PERCENT / 100;

        
        return $commission;
    }
}
