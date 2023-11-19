<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Index');
    }

    public function ldap()
    {
        return Inertia::render('Home/Index');
    }

    public function oracle()
    {
        try {
            $oracleUser = DB::connection('oracle')->select(\File::get(app_path() . '/Oracle/GetEmployee.sql'), ['matri' => 'C00801', 'eff_date' => Carbon::today()])[0];
        } catch (ModelNotFoundException|\Exception $e) {
            dd($e);
        }
    }
}
