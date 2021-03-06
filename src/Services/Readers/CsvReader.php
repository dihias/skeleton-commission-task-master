<?php
declare(strict_types=1);


namespace Feecal\Services\Readers;

class CsvReader implements Reader
{
    private $file_path;
    private $delimeter;

    public function __construct(string $file_path, string $delimeter = '')
    {
        $this->setFilePath($file_path);
        $this->setDelimeter($delimeter);
    }

    public function setFilePath(string $file_path)
    {
        if (!file_exists($file_path)) {
            throw new \Exception('Wrong path');
        }

        $this->file_path = $file_path;
    }

    public function setDelimeter(string $delimeter)
    {
        if (empty($delimeter)) {
            $this->delimeter = ',';
        } else {
            $this->delimeter = $delimeter;
        }
    }

    public function getData(): array
    {
        $results = [];
        $row = 1;
        if (($handle = fopen($this->file_path, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, $this->delimeter)) !== false) {
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $results[] = explode($this->delimeter, $data[$c]);
                }
            }
            fclose($handle);
        }

        return $results;
    }
}
