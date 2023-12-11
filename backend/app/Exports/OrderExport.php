<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings
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
            'Nome do cliente',
            'E-mail do cliente',
            'Telefone do cliente',
            'Data de nascimento do cliente',
            'Observação',
            'Valor total (R$)',
            'Produtos'
        ];
    }
}
