<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{
    public function __construct(protected collection $students) {}

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->students;
    }

    /**
     *  Write code on Method
     *
     * @return array<int,string>
     */
    public function headings(): array
    {
        return [
            'MATRICULE',
            'NOM',
            'PRÉNOM',
            'FILIÈRE',
            'ANNÉE',
            'EMAIL',
            'STATUT STAGE',
            'ENTREPRISE DE STAGE',
            'PROMOTEUR DE L\'ENTREPRISE DE STAGE',
            'TÉLÉPHONE ENTREPRISE DE STAGE',
            'ADRESSE ENTREPRISE DE STAGE',
            'NOTE DONNÉE PAR L\'ENTREPRISE',
            'NOTE DE L\'ÉTABLISSEMENT'
        ];
    }
}
