<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PromotionExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(collection $data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Nome',
            'Data de início',
            'Hora de início',
            'Data de término',
            'Hora de término',
        ];
    }
}
