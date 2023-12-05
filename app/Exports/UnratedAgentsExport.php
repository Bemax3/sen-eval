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

class UnratedAgentsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithDefaultStyles
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
        return getUnratedUsers($this->phase_id, $this->org_id)->with('org')->orderBy('rating_mark', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Agent',
            'Matricule',
            'Organisation',
        ];
    }

    public function map($row): array
    {
        return [
            $row->user_display_name,
            $row->user_matricule,
            $row->org ? $row->org_name : '',
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
