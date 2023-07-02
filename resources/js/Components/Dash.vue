<template>
        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">
                <div class="ml-2">
                    <h3 class="text-lg text-gray-600 leading-7 font-semibold">Active todos</h3>
                    <ul class="marker:text-sky-400 list-disc pl-5 space-y-3 text-slate-400">
                        <li v-for="todo in activeTodos" :key="todo.id" @click="toTodo(todo.id)" class="cursor-pointer my-2 hover:bg-blue-100 font-bold py-1 px-4 rounded text1line">
                            {{ todo.task }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                <div class="ml-2">
                    <h3 class="text-lg text-gray-600 leading-7 font-semibold">Highest Priority</h3>
                    <ul class="marker:text-sky-400 list-disc pl-5 space-y-3 text-slate-400">
                        <li v-for="todo in highestPriority" :key="todo.id" @click="toTodo(todo.id)" class="cursor-pointer my-2 hover:bg-blue-100 font-bold py-1 px-4 rounded text1line">
                            {{ todo.task }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200">
                <div class="ml-2">
                    <h3 class="text-lg text-gray-600 leading-7 font-semibold">Daily activity</h3>
                    <Chart :data="timelogs" />
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-l">
                <div class="ml-2">
                    <h3 class="text-lg text-gray-600 leading-7 font-semibold">Groups</h3>
                    <DoughnutChart :data="groupCount" />
                </div>
            </div>
        </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import Chart from '@/Components/Chart.vue'
import DoughnutChart from "@/Components/DoughnutChart.vue";

export default {
    name: "Dash",
    components: {
        DoughnutChart,
        Chart
    },
    props: {
        activeTodos:Object,
        timelogs:Object,
        groupCount:Object,
        highestPriority:Object,
    },
    methods: {
        toTodo(id){
            Inertia.replace(route('todos.view',id))
        }
    }
}
</script>

<style scoped>
.text1line {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1; /* number of lines to show */
    -webkit-box-orient: vertical;
}
</style>
