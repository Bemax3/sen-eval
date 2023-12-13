<?php

namespace App\Http\Controllers\Dashboards;

use App\Exports\AllClaimsExport;
use App\Exports\AllMobilitiesExport;
use App\Exports\AllPromotionsExport;
use App\Exports\AllSanctionsExport;
use App\Exports\AllTrainingsExport;
use App\Exports\ClaimsDetailsExport;
use App\Exports\ClaimsExport;
use App\Exports\MobilitiesDetailsExport;
use App\Exports\MobilitiesExport;
use App\Exports\PendingRatingsExport;
use App\Exports\PromotionsDetailsExport;
use App\Exports\PromotionsExport;
use App\Exports\RatedAgentsExport;
use App\Exports\SanctionsDetailsExport;
use App\Exports\SanctionsExport;
use App\Exports\TrainingsDetailsExport;
use App\Exports\TrainingsExport;
use App\Exports\UnratedAgentsExport;
use App\Http\Controllers\Controller;
use App\Models\Organisation;
use App\Models\Phase\Phase;
use App\Models\Settings\ClaimType;
use App\Models\Settings\MobilityType;
use App\Models\Settings\PromotionType;
use App\Models\Settings\SanctionType;
use App\Models\Settings\TrainingType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function downloadTrainings(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new TrainingsExport($phase_id, $org_id), 'Décompte des Formations' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public static function getNameComplement($phase_id, $org_id)
    {
        $string = '';
        if ($org_id && intval($org_id) !== -1) {
            $org = Organisation::where('org_id', '=', intval($org_id))->first();
            $string = $string . ' - ' . $org->org_name;
        }
        $phase = Phase::findOrFail($phase_id);
        return $string . ' - Année ' . $phase->phase_year;
    }

    public function downloadTrainingsDetails(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        $type = TrainingType::findOrFail($request->get('type'));
        return \Excel::download(new TrainingsDetailsExport($phase_id, $org_id, $type), 'Formations en ' . $type->training_type_name . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadAllTrainings(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        return \Excel::download(new AllTrainingsExport($phase_id, $org_id), 'Formations' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadAllClaims(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        return \Excel::download(new AllClaimsExport($phase_id, $org_id), 'Réclamations' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadAllMobilities(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        return \Excel::download(new AllMobilitiesExport($phase_id, $org_id), 'Mobilités' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadAllSanctions(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        return \Excel::download(new AllSanctionsExport($phase_id, $org_id), 'Sanctions' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadAllPromotions(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        return \Excel::download(new AllPromotionsExport($phase_id, $org_id), 'Promotions' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadClaimsDetails(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        $type = ClaimType::findOrFail($request->get('type'));
        return \Excel::download(new ClaimsDetailsExport($phase_id, $org_id, $type), 'Réclamations du type ' . $type->claim_type_name . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadMobilitiesDetails(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        $type = MobilityType::findOrFail($request->get('type'));
        return \Excel::download(new MobilitiesDetailsExport($phase_id, $org_id, $type), 'Mobilités du type ' . $type->mobility_type_name . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadSanctionsDetails(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        $type = SanctionType::findOrFail($request->get('type'));
        return \Excel::download(new SanctionsDetailsExport($phase_id, $org_id, $type), 'Sanctions du type ' . $type->sanction_type_name . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadPromotionsDetails(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        $type = PromotionType::findOrFail($request->get('type'));
        return \Excel::download(new PromotionsDetailsExport($phase_id, $org_id, $type), 'Demandes de type ' . $type->promotion_type_name . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadClaims(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new ClaimsExport($phase_id, $org_id), 'Décompte des Réclamations' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadSanctions(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new SanctionsExport($phase_id, $org_id), 'Décompte des Sanctions' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadMobilities(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new MobilitiesExport($phase_id, $org_id), 'Décompte des Mobilités' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadPromotions(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new PromotionsExport($phase_id, $org_id), 'Décompte des promotions et avancements' . self::getNameComplement($phase_id, $org_id) . '.xlsx');
    }

    public function downloadPending(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new PendingRatingsExport($phase_id, $org_id), 'Évaluation en attende de validation' . self::getNameComplement($phase_id, $org_id) . ' - ' . Carbon::today()->isoFormat('DD MMMM YYYY') . '.xlsx');
    }

    public function downloadUnrated(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new UnratedAgentsExport($phase_id, $org_id), 'Agents non évalués' . self::getNameComplement($phase_id, $org_id) . ' - ' . Carbon::today()->isoFormat('DD MMMM YYYY') . '.xlsx');
    }

    public function downloadRated(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');

        return \Excel::download(new RatedAgentsExport($phase_id, $org_id), 'Évaluations validées' . self::getNameComplement($phase_id, $org_id) . ' - ' . Carbon::today()->isoFormat('DD MMMM YYYY') . '.xlsx');
    }
}
