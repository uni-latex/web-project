<table style="border-collapse: collapse;">
    <thead>
    @foreach ($headings as $heading)
        @if ($loop->first)
            <tr>
                <th style="font-size: 14px; font-weight: bold">{{ $heading }}</th>
            </tr>
        @else
            <tr>
                <th>{{ $heading }}</th>
            </tr>
        @endif
    @endforeach
    <tr>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 15px;">Kode Barang</th>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 45px;">Nama Barang</th>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 15px;">Satuan</th>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 15px;">Saldo Awal</th>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 15px;">Pemasukan</th>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 15px;">Pengeluaran</th>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 15px;">Penyesuaian</th>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 15px;">Saldo Akhir</th>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 15px;">Stock Opname</th>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 15px;">Selisih</th>
        <th style="border: 1px solid black; text-align: center; vertical-align: center; background-color: #a0aec0; font-weight: bold; width: 15px;">Ket</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td style="border: 1px solid black; text-align: center;">{{ $model->goods_code }}</td>
            <td style="border: 1px solid black; text-align: left;">{{ $model->goods_name }}</td>
            <td style="border: 1px solid black; text-align: center;">{{ $model->unit }}</td>
            <td style="border: 1px solid black; text-align: right;">{{ $model->beginning_balance }}</td>
            <td style="border: 1px solid black; text-align: right;">{{ $model->entering }}</td>
            <td style="border: 1px solid black; text-align: right;">{{ $model->spending }}</td>
            <td style="border: 1px solid black; text-align: right;">{{ $model->compliance }}</td>
            <td style="border: 1px solid black; text-align: right;">{{ $model->final_balance }}</td>
            <td style="border: 1px solid black; text-align: right;">{{ $model->stock_opname }}</td>
            <td style="border: 1px solid black; text-align: right;">{{ $model->difference }}</td>
            <td style="border: 1px solid black;"></td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td style="border: 1px solid black; text-align: center; font-weight: bold;">TOTAL</td>
        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ collect($models)->sum('beginning_balance') }}</td>
        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ collect($models)->sum('entering') }}</td>
        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ collect($models)->sum('spending') }}</td>
        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ collect($models)->sum('compliance') }}</td>
        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ collect($models)->sum('final_balance') }}</td>
        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ collect($models)->sum('stock_opname') }}</td>
        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ collect($models)->sum('difference') }}</td>
        <td></td>
    </tr>
    </tbody>
</table>
