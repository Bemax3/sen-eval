<?php

namespace App\Exports;


use App\Models\Settings\TrainingType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TrainingsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithDefaultStyles
{

    private $phase_id;
    private $org_id;
    private $line_count;

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
        $data = getTrainingsData($this->phase_id, $this->org_id);
        $by_evaluators = 0;
        $by_evaluated = 0;
        $by_both = 0;
        $all = 0;
        foreach ($data as $training) {
            $by_evaluators += $training->trainings_by_evaluators;
            $by_evaluated += $training->trainings_by_evaluated;
            $by_both += $training->asked_by_both;
            $all += $training->trainings_count;
        }

        $data->add(new TrainingType([
            'training_type_name' => 'Totaux',
            'trainings_by_evaluators' => $by_evaluators,
            'trainings_by_evaluated' => $by_evaluated,
            'asked_by_both' => $by_both,
            'trainings_count' => $all
        ]));

        $this->line_count = count($data) + 1;
        return $data;
    }

    public function headings(): array
    {
        return [
            'Domaine',
            'Proposée par la hiérarchie',
            'Souhaitée par les agents',
            'Exprimés par les deux parties',
            'Totaux',
        ];
    }


    public function map($row): array
    {
        return [
            $row->training_type_name,
            $row->trainings_by_evaluators,
            $row->trainings_by_evaluated,
            $row->asked_by_both,
            $row->trainings_count
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            $this->line_count => ['font' => ['bold' => true, 'size' => 16]],
            'A' => ['font' => ['bold' => true, 'size' => 16]],
            'E' => ['font' => ['bold' => true, 'size' => 16]]
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return $defaultStyle->getFont()->setSize(16);
    }
}
