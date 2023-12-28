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
        $eligible_and_proposed = 0;
        $eligible_and_not_proposed = 0;
        $not_eligible_and_proposed = 0;
        $not_eligible_and_not_proposed = 0;

        foreach ($data as $promotion) {
            $eligible_and_proposed += $promotion->eligible_and_proposed_count;
            $eligible_and_not_proposed += $promotion->eligible_and_not_proposed_count;
            $not_eligible_and_proposed += $promotion->not_eligible_and_proposed_count;
            $not_eligible_and_not_proposed += $promotion->not_eligible_and_not_proposed_count;
        }

        $data->add(new PromotionType([
            'promotion_type_name' => 'Totaux',
            'eligible_and_proposed_count' => $eligible_and_proposed,
            'eligible_and_not_proposed_count' => $eligible_and_not_proposed,
            'not_eligible_and_proposed_count' => $not_eligible_and_proposed,
            'not_eligible_and_not_proposed_count' => $not_eligible_and_not_proposed,
        ]));

        $this->line_count = count($data) + 1;
        return $data;
    }

    public function headings(): array
    {
        return [
            'Type de promotion',
            'Éligibles et Proposés',
            'Éligibles et Non Proposés',
            'Non Éligibles et Proposés',
            'Non Éligibles et Non Proposés',
            'Totaux',
        ];
    }

    public function map($row): array
    {
        return [
            $row->promotion_type_name,
            $row->eligible_and_proposed_count,
            $row->eligible_and_not_proposed_count,
            $row->not_eligible_and_proposed_count,
            $row->not_eligible_and_not_proposed_count,
            $row->eligible_and_proposed_count + $row->eligible_and_not_proposed_count + $row->not_eligible_and_proposed_count + $row->not_eligible_and_not_proposed_count
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
