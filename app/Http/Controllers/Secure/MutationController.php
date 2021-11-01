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

        $model = config('customs.mutations.models')[$filters['mutation_type']];

        $models = $model::query()
            ->select($this->columnSelect())
            ->filter($filters)
            ->groupby('goods_code')
            ->paginate(config('customs.paginate'))
            ->withQueryString();

        return Inertia::render('Secure/Mutation/Index', [
            "fields" => [
                'mutation_types' => config('customs.mutations.mutation_types'),
            ],
            'filters' => $filters,
            'models' => $models,
        ]);
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
            'mutation_type' => array_key_first(config('customs.mutations.mutation_types')),
            'start_date' => now()->subMonths(config('customs.start_date_month'))->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'goods_code' => '',
            'goods_name' => '',
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

        $filters = $this->filters($request);

        $mutationName = config('customs.mutations.mutation_types')[$filters['mutation_type']];

        $reportName = "LAPORAN PERTANGGUNGJAWABAN MUTASI " . Str::upper($mutationName);
        $headingStartDate = Carbon::parse($filters['start_date'])->format('d F Y');
        $headingEndDate = Carbon::parse($filters['end_date'])->format('d F Y');
        $companyName = strtoupper(nova_get_setting('name', config('app.name')));

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

        $model = config('customs.mutations.models')[$filters['mutation_type']];

        $models = $model::query()
            ->select($this->columnSelect())
            ->filter($filters)
            ->groupby('goods_code')
            ->get();

        return Excel::download(
            new MutationViewExport($request, $models, $headings),
            $filename
        );
    }
}
