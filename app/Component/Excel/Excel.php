<?php
namespace App\Component\Excel;

use App\Concerns\Excel\ExcelInterface;

class Excel extends AbstractExcel implements ExcelInterface
{
    public array $header = ['service', 'bank'];

    public function getHeader(): array
    {
        return $this->header;
    }
}