<?php


namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MutationImport implements ToCollection, WithStartRow, WithValidation
{
    protected $uploadModel;

    protected $model;

    public function __construct($model)
    {
        $this->uploadModel = $model;

        $this->model = $model->file_model;
    }

    public function collection(Collection $collection)
    {
        $models = $this->model::where('mutation_date', $this->uploadModel->file_date);

        if ($models->count()) {

            $models->delete();

        }

        $this->createData($collection);
    }

    private function createData($collection)
    {
        foreach($collection as $row) {

            // jika row ada isi maka create mutation
            if ($row[0]) {

                $this->createMutation($row);

            }

        }

    }

    private function createMutation($row)
    {
        $this->model::create([
            'mutation_date' => $this->uploadModel->file_date,
            'goods_code' => $row[0],
            'goods_name' => $row[1],
            'unit' => $row[2],
            'beginning_balance' => $row[3],
            'entering' => $row[4],
            'spending' => $row[5],
            'compliance' => $row[6],
            'final_balance' => $row[7],
            'stock_opname' => $row[8],
            'difference' => $row[9],
            'annotation' => $row[10],
        ]);
    }

    public function startRow(): int
    {
        return 12;
    }

    public function rules(): array
    {
        return [
//            '0' => 'required',
//            '1' => 'required',
//            '2' => 'required',
            '3' => 'required',
            '4' => 'required',
            '5' => 'required',
            '6' => 'required',
            '7' => 'required',
            '8' => 'required',
            '9' => 'required',
        ];
    }
}
