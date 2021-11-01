<table style="border-collapse: collapse;">
    <thead>
    @foreach ($headings as $heading)
        <tr>
            <th>{{ $heading }}</th>
        </tr>
    @endforeach
    <tr>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 40px;" rowspan="2">No</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 100px;" rowspan="2">Jenis Dokumen</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold;" colspan="2">Dokumen Pabean</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold;" colspan="2">Bukti Penerimaan Barang</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 250px;" rowspan="2">
            @if ($transaction_type == 0)
                Pembeli / Penerima
            @else
                Pemasok / Pengirim
            @endif
        </th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold;" rowspan="2">Kode Brg.</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 250px;" rowspan="2">Nama Barang - 1</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 250px;" rowspan="2">Nama Barang - 2</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold;" rowspan="2">Sat.</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 120px;" rowspan="2">Jumlah</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold;" rowspan="2">Valas</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 120px;" rowspan="2">Nilai Barang</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold;" rowspan="2">Ket.- 1</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold;" rowspan="2">Ket.- 2</th>
    </tr>
    <tr>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 80px;">Nomor</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 80px;">Tanggal</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 80px;">Nomor</th>
        <th style="border: 1px solid black; text-align: center; background-color: #a0aec0; font-weight: bold; width: 80px;">Tanggal</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($documents as $index => $document)
        @foreach ($document->items as $item)
            @if ($loop->first)
                <tr>
                    <td style="border: 1px solid black; text-align: center;" rowspan="{{ count($document->items) }}">{{ $index + 1 }}</td>
                    <td style="border: 1px solid black; text-align: center;" rowspan="{{ count($document->items) }}">{{ $document->doc_type }}</td>
                    <td style="border: 1px solid black; text-align: center;" rowspan="{{ count($document->items) }}">{{ $document->doc_number }}</td>
                    <td style="border: 1px solid black; text-align: center;" rowspan="{{ count($document->items) }}">{{ $document->doc_date->format('d/m/Y') }}</td>
                    <td style="border: 1px solid black; text-align: center;" rowspan="{{ count($document->items) }}">{{ $item->receipt_number }}</td>
                    <td style="border: 1px solid black; text-align: center;" rowspan="{{ count($document->items) }}">{{ $item->receipt_date->format('d/m/Y') }}</td>
                    <td style="border: 1px solid black;" rowspan="{{ count($document->items) }}">{{ $document->vendor }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $item->goods_code }}</td>
                    <td style="border: 1px solid black;">{{ $item->goods_name_1 }}</td>
                    <td style="border: 1px solid black;">{{ $item->goods_name_2 }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $item->unit }}</td>
                    <td style="border: 1px solid black; text-align: right;">{{ $item->quantity }}</td>
                    {{--                    <td style="border: 1px solid black; text-align: right;">{{ number_format($item->quantity, 2) }}</td>--}}
                    <td style="border: 1px solid black; text-align: center;">{{ $item->valas }}</td>
                    <td style="border: 1px solid black; text-align: right;">{{ $item->value }}</td>
                    {{--                    <td style="border: 1px solid black; text-align: right;">{{ number_format($item->value, 2) }}</td>--}}
                    <td style="border: 1px solid black;">{{ $item->annotation_1 }}</td>
                    <td style="border: 1px solid black;">{{ $item->annotation_2 }}</td>
                </tr>
            @else
                <tr>
                    <td style="border: 1px solid black; text-align: center;">{{ $item->goods_code }}</td>
                    <td style="border: 1px solid black;">{{ $item->goods_name_1 }}</td>
                    <td style="border: 1px solid black;">{{ $item->goods_name_2 }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $item->unit }}</td>
                    <td style="border: 1px solid black; text-align: right;">{{ $item->quantity }}</td>
                    {{--                    <td style="border: 1px solid black; text-align: right;">{{ number_format($item->quantity, 2) }}</td>--}}
                    <td style="border: 1px solid black; text-align: center;">{{ $item->valas }}</td>
                    <td style="border: 1px solid black; text-align: right;">{{ $item->value }}</td>
                    {{--                    <td style="border: 1px solid black; text-align: right;">{{ number_format($item->value, 2) }}</td>--}}
                    <td style="border: 1px solid black;">{{ $item->annotation_1 }}</td>
                    <td style="border: 1px solid black;">{{ $item->annotation_2 }}</td>
                </tr>
            @endif
        @endforeach
    @endforeach
    <tr>
        <td colspan="10"></td>
        <td style="border: 1px solid black; text-align: center; font-weight: bold;">Total</td>
        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ collect($documents)->sum(function ($document) { return $document->items->sum('quantity'); }) }}</td>
        {{--        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ number_format(collect($documents)->sum(function ($document) {--}}
        {{--        return $document->items->sum('quantity');--}}
        {{--    }), 2) }}</td>--}}
        <td></td>
        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ collect($documents)->sum(function ($document) { return $document->items->sum('value'); }) }}</td>
        {{--        <td style="border: 1px solid black; text-align: right; font-weight: bold;">{{ number_format(collect($documents)->sum(function ($document) {--}}
        {{--        return $document->items->sum('value');--}}
        {{--    }), 2) }}</td>--}}
    </tr>
    </tbody>
</table>
