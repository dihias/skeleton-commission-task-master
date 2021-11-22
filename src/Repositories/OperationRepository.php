<?php

namespace Feecal\Repositories;

interface OperationRepository
{
    public function getAll(): array;

    public function getPersonWithdrawOperationsFromSameWeek(int $person_id, $date): array;
}
