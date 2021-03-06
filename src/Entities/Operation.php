<?php

namespace Feecal\Entities;

class Operation
{
    private $id;
    private $name;
    private $date;
    private $person_id;
    private $person_type;
    private $amount;
    private $currency;
    const withdraw = 'withdraw';
    const deposit = 'deposit';

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDate(string $date)
    {
        $this->date = $date;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setPersonId(int $person_id)
    {
        $this->person_id = $person_id;
    }

    public function getPersonId(): int
    {
        return $this->person_id;
    }

    public function setPersonType(string $person_type)
    {
        $this->person_type = $person_type;
    }

    public function getPersonType(): string
    {
        return $this->person_type;
    }

    public function setAmount(string $amount)
    {
        $this->amount = $amount;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
