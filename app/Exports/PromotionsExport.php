<?php

namespace App\Exports;

use App\Models\Settings\PromotionType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PromotionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithDefaultStyles
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
        $data = getPromotionsData($this->phase_id, $this->org_id);
        $eligible = 0;
        $others = 0;
        $all = 0;
        foreach ($data as $promotion) {
            $eligible += $promotion->eligible_count;
            $others += $promotion->others;
            $all += $promotion->eligible_count + $promotion->others;
        }

        $data->add(new PromotionType([
            'promotion_type_name' => 'Totaux',
            'eligible_count' => $eligible,
            'others' => $others,
        ]));

        $this->line_count = count($data) + 1;
        return $data;
    }

    public function headings(): array
    {
        return [
            'Type de promotion',
            'Proposé et éligible',
            'Proposé et non éligible',
            'Totaux',
        ];
    }


    public function map($row): array
    {
        return [
            $row->promotion_type_name,
            $row->eligible_count,
            $row->others,
            $row->eligible_count + $row->others
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
