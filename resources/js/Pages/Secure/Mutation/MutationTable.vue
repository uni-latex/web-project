<template>
    <div v-if="models.data.length > 0" class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 text-sm">

        <div v-if="$page.props.user.can['downloadMutations']" class="flex justify-end mb-6">
            <button @click="download" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                Download
            </button>
        </div>

        <div class="overflow-auto">

            <table class="w-full">

                <thead class="bg-primary">
                    <tr class="border">
                        <th class="border p-2" rowspan="2">No.</th>
                        <th class="border p-2" colspan="2">Barang</th>
                        <th class="border p-2" rowspan="2">Satuan</th>
                        <th class="border p-2" rowspan="2">Saldo Awal</th>
                        <th class="border p-2" rowspan="2">Pemasukan</th>
                        <th class="border p-2" rowspan="2">Pengeluaran</th>
                        <th class="border p-2" rowspan="2">Penyesuaian</th>
                        <th class="border p-2" rowspan="2">Saldo Akhir</th>
                        <th class="border p-2" rowspan="2">Stock Opname</th>
                        <th class="border p-2" rowspan="2">Selisih</th>
                    </tr>
                    <tr>
                        <th class="border p-2">Kode</th>
                        <th class="border p-2">Nama</th>
                    </tr>
                </thead>

                <tbody v-for="(model, index) in models.data" class="hover:bg-primary-50 text-left" :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-100'">
                    <tr>
                        <td class="border p-2 text-center">{{ models.from + index }}</td>
                        <td class="border p-2 truncate">{{ model.goods_code }}</td>
                        <td class="border p-2 truncate">{{ model.goods_name }}</td>
                        <td class="border p-2">{{ model.unit }}</td>
                        <td class="border p-2 text-right">{{ model.beginning_balance | numeralFormat }}</td>
                        <td class="border p-2 text-right">{{ model.entering | numeralFormat }}</td>
                        <td class="border p-2 text-right">{{ model.spending | numeralFormat }}</td>
                        <td class="border p-2 text-right">{{ model.compliance | numeralFormat }}</td>
                        <td class="border p-2 text-right">{{ model.final_balance | numeralFormat }}</td>
                        <td class="border p-2 text-right">{{ model.stock_opname | numeralFormat }}</td>
                        <td class="border p-2 text-right">{{ model.difference | numeralFormat }}</td>
                    </tr>
                </tbody>

            </table>

        </div>

        <Pagination class="mt-6" :links="models.links" />
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
            'models',
        ],

        methods: {
            download() {
                this.$emit('on-download')
            }
        }
    }
</script>
