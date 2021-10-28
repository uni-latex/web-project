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

    protected $mutationNamespace = "App\\Models\\Customs\\";

    public function __construct($model)
    {
        $this->uploadModel = $model;

        $this->model = $this->mutationNamespace . $model->transaction_type;
    }

    public function collection(Collection $collection)
    {
        // TODO: Implement collection() method.
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
