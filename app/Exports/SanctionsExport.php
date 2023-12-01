<?php

namespace App\Exports;

use App\Models\Settings\SanctionType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SanctionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithDefaultStyles
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
        $data = getSanctionsData($this->phase_id, $this->org_id);
        $data->add(new SanctionType([
            'sanction_type_name' => 'Total',
            'sanctions_count' => $data->sum('sanctions_count')
        ]));
        $this->line_count = count($data) + 1;
        return $data;
    }

    public function headings(): array
    {
        return [
            'Type de sanction',
            'Exprimées',
        ];
    }

    public function map($row): array
    {
        return [
            $row->sanction_type_name,
            $row->sanctions_count
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            $this->line_count => ['font' => ['bold' => true, 'size' => 16]],
            'A' => ['font' => ['bold' => true, 'size' => 16]],
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return $defaultStyle->getFont()->setSize(16);
    }
}
