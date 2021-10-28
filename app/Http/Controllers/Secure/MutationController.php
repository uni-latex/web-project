<?php

namespace App\Http\Controllers\Secure;


use App\Exports\MutationViewExport;
use App\Http\Controllers\Controller;
use App\Models\Customs\BahanBakuDanPenolong;
use App\Models\Customs\BarangDalamProses;
use App\Models\Customs\BarangJadi;
use App\Models\Customs\BarangSisaDanScrap;
use App\Models\Customs\BarangSparepart;
use App\Models\Customs\MesinDanPeralatanKantor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class MutationController extends Controller
{
    public function index(Request $request)
    {
        if (! Auth::user()->can('viewMutations')) {
            return Redirect::route('dashboard');
        }

        $filters = $this->filters($request);

        $models = $this->mutationModel($filters['mutation_type'])::query()
            ->select($this->columnSelect())
            ->whereBetween('mutation_date', [$filters['start_date'], $filters['end_date']])
            ->groupby('goods_code');

        $models = $models->paginate($filters['per_page'])
            ->withQueryString();

        return Inertia::render('Secure/Mutation/Index', [
            'filters' => $filters,
            'models' => $models,
        ]);
    }

    private function mutationModel($mutation_type)
    {
        $models = [
            'bbp' => BahanBakuDanPenolong::class,
            'bdp' => BarangDalamProses::class,
            'bj' => BarangJadi::class,
            'bs' => BarangSparepart::class,
            'bsds' => BarangSisaDanScrap::class,
            'mdpk' => MesinDanPeralatanKantor::class,
        ];

        return $models[$mutation_type];
    }

    private function columnSelect()
    {
        return [
            'goods_code',
            DB::raw('max(goods_name) as goods_name'),
            DB::raw('max(unit) as unit'),
            DB::raw("SUBSTRING_INDEX(GROUP_CONCAT(CAST(beginning_balance AS CHAR) ORDER By mutation_date asc), ',', 1) AS beginning_balance"),
            DB::raw('SUM(entering) AS entering'),
            DB::raw('SUM(spending) AS spending'),
            DB::raw('SUM(compliance) AS compliance'),
            DB::raw("SUBSTRING_INDEX(GROUP_CONCAT(CAST(final_balance AS CHAR) ORDER By mutation_date DESC), ',', 1) AS final_balance"),
            DB::raw('SUM(stock_opname) AS stock_opname'),
            DB::raw("SUBSTRING_INDEX(GROUP_CONCAT(CAST(difference AS CHAR) ORDER By mutation_date DESC), ',', 1) AS difference")
        ];
    }

    private function filters(Request $request)
    {
        $filters = [
            'mutation_type' => 'bbp',
            'start_date' => now()->subMonths(2)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'per_page' => 25,
        ];

        foreach ($filters as $key => $value) {
            $filters[$key] = $request->get($key) ?? $filters[$key];
        }

        return $filters;
    }

    public function download(Request $request)
    {
        if (! $request->user()->can('downloadMutations')) {
            return redirect(route('mutations'));
        }

        $mutation_type = $request->mutation_type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $reportName = "LAPORAN PERTANGGUNGJAWABAN MUTASI " . Str::upper($this->mutationName($mutation_type));
        $headingStartDate = Carbon::parse($startDate)->format('d F Y');
        $headingEndDate = Carbon::parse($endDate)->format('d F Y');
        $companyName = strtoupper(config('app.name'));

        $headings = [
            $reportName,
            "",
            "",
            "NAMA KAWASAN BERIKAT : PT. {$companyName}",
            $reportName,
            "PERIODE PELAPORAN : {$headingStartDate} - {$headingEndDate}",
            "",
            "",
            "",
            "",
        ];

        $filename = "{$reportName}.xls";

        $models = $this->mutationModel($mutation_type)::query()
            ->select($this->columnSelect())
            ->whereBetween('mutation_date', [$startDate, $endDate])
            ->groupby('goods_code')
            ->get();

        return Excel::download(
            new MutationViewExport($request, $models, $headings),
            $filename
        );
    }

    private function mutationName($mutation_type)
    {
        $names = [
            'bbp' => 'Bahan Baku dan Bahan Penolong',
            'bdp' => 'Posisi Barang dalam Proses ( WIP )',
            'bj' => 'Barang Jadi',
            'bs' => 'Barang Sparepart',
            'bsds' => 'Barang Sisa dan Scrap',
            'mdpk' => 'Mesin dan Peralatan Kantor'
        ];

        return $names[$mutation_type];
    }
}
