<?php

namespace App\Http\Controllers\Dashboards;

use App\Exports\ClaimsExport;
use App\Exports\MobilitiesExport;
use App\Exports\PromotionsExport;
use App\Exports\SanctionsExport;
use App\Exports\TrainingsExport;
use App\Http\Controllers\Controller;
use App\Models\Organisation;
use App\Models\Phase\Phase;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function downloadTrainings(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new TrainingsExport($phase_id, $org_id), 'Besoin en Formation' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public static function getNameComplement($phase_id, $org_id)
    {
        $string = '';
        if ($org_id && intval($org_id) !== -1) {
            $org = Organisation::where('org_id', '=', intval($org_id))->first();
            $string = $string . ' - ' . $org->org_name;
        }
        $phase = Phase::findOrFail($phase_id);
        return $string . ' - ' . $phase->phase_year;
    }

    public function downloadClaims(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new ClaimsExport($phase_id, $org_id), 'Réclamations' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadSanctions(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new SanctionsExport($phase_id, $org_id), 'Sanctions' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadMobilities(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new MobilitiesExport($phase_id, $org_id), 'Mobilités' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadPromotions(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new PromotionsExport($phase_id, $org_id), 'Promotions et avancements' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }
}
