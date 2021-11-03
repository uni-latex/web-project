<?php


namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MutationExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting
{
    use Exportable;

    private $filters;
    private $model;

    public function __construct($model, array $filters)
    {
        $this->model = $model;
        $this->filters = $filters;
    }

    public function collection()
    {
        return $this->model::query()
            ->select($this->columnSelect())
            ->filter($this->filters)
            ->groupby('goods_code')
            ->get();
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

    public function map($row): array
    {
        return [
            $row->goods_code,
            $row->goods_name,
            $row->unit,
            $row->beginning_balance,
            $row->entering,
            $row->spending,
            $row->compliance,
            $row->final_balance,
            $row->stock_opname,
            $row->difference,
        ];
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            "Nama Barang",
            "Satuan",
            "Saldo Awal",
            "Pemasukan",
            "Pengeluaran",
            "Penyesuaian",
            "Saldo Akhir",
            "Stock Opname",
            "Selisih",
            "Ket"
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
        ];
    }
}
