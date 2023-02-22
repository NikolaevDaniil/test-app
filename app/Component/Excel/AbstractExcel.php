<?php

namespace App\Component\Excel;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Exception;

abstract class AbstractExcel extends IOFactory
{
    private array $data;
    private mixed $service;
    private $file;

    public function __construct($file)
    {
        $this->setFile($file);
        $this->service = self::load($this->getFile())->getActiveSheet();
        $this->data = $this->setDataArray($this->service->toArray());
    }

    public function setFile( $file): void
    {
        $this->file = $file;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function addHeader(): void
    {
        $this->data[0] = Arr::collapse([$this->data[0], $this->getHeader()]);
    }

    private function setDataArray($data): array
    {
        $this->data = $data;

        return $this->data;
    }

    public function getDataArray(): array
    {
        return $this->data;
    }

    /**
     * @throws Exception
     */
    public function saveData(): void
    {
        $this->service->fromArray($this->getDataArray());
        $writer = self::createWriter($this->service, 'Xlsx');
        $writer->save($this->getFile());

    }


}