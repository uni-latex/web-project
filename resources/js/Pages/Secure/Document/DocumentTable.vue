<template>
    <div v-if="documents.data.length > 0" class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">
        <div class="overflow-auto">

            <table class="w-full">

                <thead class="bg-primary">
                    <tr class="border">
                        <th class="border p-2" rowspan="2">No</th>
                        <th class="border p-2" rowspan="2">Jenis<br>Dok.</th>
                        <th class="border p-2" colspan="2">Dokumen Pabean</th>
                        <th class="border p-2" colspan="2">Bukti Penerimaan Barang</th>
                        <th v-if="transaction_type === 1" class="border p-2" rowspan="2">Pemasok / Pengirim</th>
                        <th v-else class="border p-2" rowspan="2">Pembeli / Penerima</th>
                        <th class="border p-2" colspan="2">Detail Barang</th>
                        <th class="border p-2" rowspan="2">Satuan</th>
                        <th class="border p-2" rowspan="2">Valas</th>
                        <th class="border p-2" rowspan="2">Jumlah</th>
                        <th class="border p-2" rowspan="2">Nilai Barang</th>
                    </tr>
                    <tr>
                        <th class="border p-2">Nomor</th>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Nomor</th>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Kode</th>
                        <th class="border p-2">Nama</th>
                    </tr>
                </thead>

                <tbody v-for="(document, index) in documents.data" class="hover:bg-primary-50" :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-100'">
                    <tr class="align-top" v-for="(item, itemIndex) in document.items" v-if="itemIndex === 0">
                        <td class="border p-2" :rowspan="document.items.length">{{ documents.from + index}}</td>
                        <td class="border p-2" :rowspan="document.items.length">{{ document.doc_type }}</td>
                        <td class="border p-2" :rowspan="document.items.length">{{ document.doc_number }}</td>
                        <td class="border p-2" :rowspan="document.items.length">{{ document.doc_date }}</td>
                        <td class="border p-2 truncate" :rowspan="document.items.length">{{ item.receipt_number }}</td>
                        <td class="border p-2" :rowspan="document.items.length">{{ item.receipt_date }}</td>
                        <td class="border p-2 text-left" :rowspan="document.items.length">{{ document.vendor }}</td>
                        <td class="border p-2 text-left truncate">{{ item.goods_code }}</td>
                        <td class="border p-2 text-left">{{ goodsName(item) }}</td>
                        <td class="border p-2">{{ item.unit }}</td>
                        <td class="border p-2">{{ item.valas }}</td>
                        <td class="border p-2 text-right">{{ item.quantity | numeralFormat }}</td>
                        <td class="border p-2 text-right">{{ item.value | numeralFormat }}</td>
                    </tr>
                    <tr class="align-top" v-else>
                        <td class="border p-2 text-left truncate">{{ item.goods_code }}</td>
                        <td class="border p-2 text-left truncate">{{ goodsName(item) }}</td>
                        <td class="border p-2">{{ item.unit }}</td>
                        <td class="border p-2">{{ item.valas }}</td>
                        <td class="border p-2 text-right">{{ item.quantity | numeralFormat }}</td>
                        <td class="border p-2 text-right">{{ item.value | numeralFormat }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Pagination class="mt-6" :links="documents.links" />
    </div>
    <div v-else class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">
        <div class="h-24 flex justify-center items-center">
            <span class="text-2xl tracking-widest">No data</span>
        </div>
    </div>
</template>

<script>
    import Pagination from "@/Components/Pagination";

    export default {
        components: {
            Pagination,
        },

        props: [
            'documents',
        ],

        data() {
            return {
                transaction_type: 1,
            }
        },

        methods: {
            goodsName(item) {
                let name = item.goods_name_1
                if (item.goods_name_2) {
                    name += ' ' + item.goods_name_2
                }
                return name
            }
        },
    }
</script>
