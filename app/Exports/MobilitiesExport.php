<?php

namespace App\Exports;

use App\Models\Settings\MobilityType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MobilitiesExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, WithDefaultStyles
{
    private mixed $phase_id;
    private mixed $org_id;
    private mixed $line_count;

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
        $data = getMobilitiesData($this->phase_id, $this->org_id);
        $by_evaluators = 0;
        $by_evaluated = 0;
        $all = 0;
        foreach ($data as $mobility) {
            $by_evaluators += $mobility->mobilities_by_evaluators;
            $by_evaluated += $mobility->mobilities_by_evaluated;
            $all += $mobility->mobilities_by_evaluators + $mobility->mobilities_by_evaluated;
        }
        $data->add(new MobilityType([
            'mobility_type_name' => 'Totaux',
            'mobilities_by_evaluators' => $by_evaluators,
            'mobilities_by_evaluated' => $by_evaluated,
        ]));

        $this->line_count = count($data) + 1;

        return $data;

    }

    public function headings(): array
    {
        return [
            'Type de mobilité',
            'Proposée par la hiérarchie',
            'Souhaitée par les agents',
            'Totaux',
        ];
    }


    public function map($row): array
    {
        return [
            $row->mobility_type_name,
            $row->mobilities_by_evaluators,
            $row->mobilities_by_evaluated,
            $row->mobilities_by_evaluators + $row->mobilities_by_evaluated,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            $this->line_count => ['font' => ['bold' => true, 'size' => 16]],
            'A' => ['font' => ['bold' => true, 'size' => 16]],
            'D' => ['font' => ['bold' => true, 'size' => 16]],
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return $defaultStyle->getFont()->setSize(16);
    }

}
