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

class AllTrainingsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithDefaultStyles
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
        return getAllTrainings($this->phase_id, $this->org_id)->with('rating', 'rating.evaluated', 'rating.evaluator', 'type')->get();
    }

    public function headings(): array
    {
        return [
            'Formation',
            'Évalué',
            'Évaluateur',
            'Demandée par'
        ];
    }


    public function map($row): array
    {
        return [
            $row->type->training_type_name,
            $row->rating->evaluated->user_display_name,
            $row->rating->evaluator->user_display_name,
            match (true) {
                $row->asked_by_evaluted == 1 && !$row->asked_by_evaluator == Null => $row->rating->evaluated->user_display_name,
                !$row->asked_by_evaluted == Null && $row->asked_by_evaluator == 1 => $row->rating->evaluator->user_display_name,
                default => $row->rating->evaluated->user_display_name . ' et ' . $row->rating->evaluator->user_display_name,
            }
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
