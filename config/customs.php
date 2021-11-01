<?php

return [
    "documents" => [
        'transaction_types' => [
            0 => 'Keluar',
            1 => 'Masuk',
        ],
        'document_types' => [
            'BC2.3' => 'BC 2.3',
            'BC2.5' => 'BC 2.5',
            'BC2.61' => 'BC 2.61',
            'BC2.62' => 'BC 2.62',
            'BC2.7' => 'BC 2.7',
            'BC3.0' => 'BC 3.0',
            'BC4.0' => 'BC 4.0',
            'BC4.1' => 'BC 4.1'
        ],
    ],

    "mutations" => [
        'mutation_types' => [
            'bbp' => "Bahan Baku dan Bahan Penolong",
            "bdp" => "Posisi Barang dalam Proses ( WIP )",
            "bj" => "Barang Jadi",
            "bs" => "Barang Sparepart",
            "bsds" => "Barang Sisa dan Scrap",
            "mdpk" => "Mesin dan Peralatan Kantor",
        ],
        'models' => [
            'bbp' => App\Models\Customs\BahanBakuDanPenolong::class,
            'bdp' => App\Models\Customs\BarangDalamProses::class,
            'bj' => App\Models\Customs\BarangJadi::class,
            'bs' => App\Models\Customs\BarangSparepart::class,
            'bsds' => App\Models\Customs\BarangSisaDanScrap::class,
            'mdpk' => App\Models\Customs\MesinDanPeralatanKantor::class,
        ],
    ],

    "logs" => [
        'upload_types' => [
            'document' => 'Document',
            'mutation' => 'Mutation'
        ],
    ],

    'start_date_month' => 1,

    'paginate' => 25,
];
