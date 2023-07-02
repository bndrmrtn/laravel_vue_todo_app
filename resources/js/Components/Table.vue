<template>
    <table class="table-auto">
        <tr>
            <th v-for="cn in columnNames" :key="cn" class="border px-4 py-2">{{ cn }}</th>
            <th class="border px-4 py-2"></th>
        </tr>
        <tr v-for="item in items" :key="item.id">
            <template v-for="cn in columnNames">
                <td class="border px-4 py-2">
                    {{ item[dataMapping[cn]] }}
                </td>
            </template>
            <td class="border px-4 py-2">
                <Link :href="route('todos.view',item.id)" class="m-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    <LinkIcon/>
                </Link>
                <button @click="destroy(item.id)" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">
                    <TrashIcon/>
                </button>
            </td>
        </tr>
    </table>
</template>

<script>
import LinkIcon from '@/Icons/Link.vue'
import TrashIcon from '@/Icons/Trash.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: "Table",
    components: {
        LinkIcon,
        TrashIcon,
        Link,
    },
    props: {
        url: String,
        columnNames: Object,
        dataMapping: Object,
        items:Object,
    },
    methods:{
        destroy(id){

        }
    },
}
</script>

<style scoped>

</style>
