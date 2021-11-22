<?php
declare(strict_types=1);


namespace Feecal\Services\Commissions;

use Feecal\Entities\Operation;

abstract class CommissionStrategy
{
    protected $operation;

    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    abstract public function calculate();
}
