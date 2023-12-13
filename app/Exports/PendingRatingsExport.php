<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendingRatingsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithDefaultStyles
{
    private mixed $phase_id;
    private mixed $org_id;


    public function __construct($phase_id, $org_id)
    {
        $this->phase_id = $phase_id;
        $this->org_id = $org_id;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return getPendingRatings($this->phase_id, $this->org_id)->get();
    }

    public function headings(): array
    {
        return [
            'Agent',
            'Matricule',
            'Organisation',
            'Évaluateur'
        ];
    }


    public function map($row): array
    {
        return [
            $row->evaluated->user_display_name,
            $row->evaluated->user_matricule,
            $row->evaluated->org->org_name,
            $row->evaluator->user_display_name,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            'A' => ['font' => ['bold' => true, 'size' => 16]],
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return $defaultStyle->getFont()->setSize(16);
    }
}
