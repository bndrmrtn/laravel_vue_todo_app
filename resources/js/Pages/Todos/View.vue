<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import UserLayout from '@/Layouts/UserLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

import CheckIcon from '@/Icons/Check.vue';
import CommentIcon from '@/Icons/Comment.vue';
import StopWatchIcon from '@/Icons/StopWatch.vue';
import EditIcon from '@/Icons/Edit.vue';


export default {
    setup() {
        const todo = computed(() => usePage().props.value.todo)
        const active = computed(() => usePage().props.value.active)
        const timelogs = computed(() => usePage().props.value.timelogs)
        const warn = computed(() => usePage().props.errors)
        return { todo, active, timelogs, warn }
    },
    data(){
        return {
            wtime:0,
            loaded:false,
        }
    },
    components: {
        UserLayout,
        Link,
        CheckIcon,
        CommentIcon,
        StopWatchIcon,
        EditIcon,
    },
    methods: {
        reload(){
            Inertia.reload();
        },
        changeActivity(){
            Inertia.replace(route('todos.activity.change',this.todo.id))
        },
        readableDate(date){
            date = new Date(date);
            return date.toDateString() + ' ' + date.toLocaleTimeString()
        },
        toTimestamp(strDate){
            const dt = Date.parse(strDate);
            return dt / 1000;
        },
        timeCalculator(seconds) {
            let y = Math.floor(seconds / 31536000);
            let mo = Math.floor((seconds % 31536000) / 2628000);
            let d = Math.floor(((seconds % 31536000) % 2628000) / 86400);
            let h = Math.floor((seconds % (3600 * 24)) / 3600);
            let m = Math.floor((seconds % 3600) / 60);
            let s = Math.floor(seconds % 60);

            let yDisplay = y > 0 ? y + (y === 1 ? " year, " : " years, ") : "";
            let moDisplay = mo > 0 ? mo + (mo === 1 ? " month, " : " months, ") : "";
            let dDisplay = d > 0 ? d + (d === 1 ? " day, " : " days, ") : "";
            let hDisplay = h > 0 ? h + (h === 1 ? " hour, " : " hours, ") : "";
            let mDisplay = m > 0 ? m + (m === 1 ? " minute " : " minutes, ") : "";
            let sDisplay = s > 0 ? s + (s === 1 ? " second" : " seconds ") : "";
            return yDisplay + moDisplay + dDisplay + hDisplay + mDisplay + sDisplay;
        },
        getLogTime(log){
            const time = this.toTimestamp(log.updated_at) - this.toTimestamp(log.created_at)
            return time
        },
        finishTask(){
            if(confirm('Are you sure you want to finish this task?')) Inertia.replace(route('todos.finish',this.todo.id));
        },
        update(){
            this.wtime = 0
            this.loaded = false;
            this.loaded = true;
        }
    },
    mounted(){
        this.loaded = true;
    },
    computed: {
        getTimelog(){
            const tl = this.timelogs.filter((log) => {
                return log.finished === 1
            })
            tl.forEach(log => {
                this.wtime += this.getLogTime(log)
            })
            return tl
        }
    },
    watch: {
        '$page': function () {
            this.update()
        }
    },
}
</script>

<template>
    <UserLayout :title="todo.task">
        <div class="m-2 md:grid grid-cols-2 gap-1" v-if="loaded">
            <div>
                <h3 class="font-semibold text-xl mb-5">Todo</h3>
                <p class="text-slate-500 text">{{ todo.task }}</p>
                <br>
                <p>Priority: {{ todo.priority + 1     }}</p>
                <p>Created at: {{ readableDate(todo.created_at) }}</p>
                <p>Last modified: {{ readableDate(todo.updated_at) }}</p>
                <p v-if="wtime">Total time spent: {{ timeCalculator(wtime) }}</p>
                <Link :href="route('todos.comments',todo.id)" class="inline-flex my-4 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    Comments&nbsp;<CommentIcon/>
                </Link>
                <div v-if="!todo.finished">
                    <button v-if="!active" @click="changeActivity" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        Start Activity&nbsp;<StopWatchIcon/>
                    </button>
                    <button v-if="active" @click="changeActivity"  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        Stop Activity&nbsp;<StopWatchIcon/>
                    </button>
                    <button @click="finishTask" class="ml-2 inline-flex items-center py-2 justify-center px-4 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-400 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
                        Finish Task&nbsp;<CheckIcon/>
                    </button>
                </div>
                <div v-else>
                    <p class="text-green-600">Finished <CheckIcon/></p>
                </div>
                <div>
                    <p v-if="$page.props.errors.warn" class="text-red-600">{{$page.props.errors.warn}}</p>
                </div>
            </div>
            <div class="md:ml-5">
                <h3 class="font-semibold text-xl mt-10 md:mt-0">Activities</h3>
                <ul v-if="timelogs && timelogs[0]" class="timelogul marker:text-sky-400 list-disc pl-5 space-y-3 text-slate-400" >
                    <li v-for="log in getTimelog" :key="log.id" class="my-2 hover:bg-blue-100 font-bold py-2 px-4 rounded">
                        <template v-if="log && log.finished">
                            {{ timeCalculator(getLogTime(log)) }}
                        </template>
                    </li>
                </ul>
                <div v-else>
                    No activity found
                </div>
            </div>
        </div>
        <br>
        <Link :href="route('todos')" class="m-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Back
        </Link>
        <Link v-if="!todo.finished" :href="route('todos.edit',todo.id)" class="m-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Edit&nbsp;<EditIcon/>
        </Link>
    </UserLayout>
</template>

<style scoped>
.timelogul {
    max-height: 50vh;
    overflow-y: scroll;
}
</style>
