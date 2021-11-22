<?php
declare(strict_types=1);

namespace Feecal\Services\Readers;

interface Reader{

    public function getData():array;
}