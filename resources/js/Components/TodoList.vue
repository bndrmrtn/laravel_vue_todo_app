<template>
    <div class="wrap">
        <div v-for="todo in todos.data" :key="todo.id" class="p-6 flex sm:max-w-sm max-w-7xl mx-auto bg-white sm:rounded-xl sm:shadow-lg items-center space-x-4 my-2">
                <div class="sm:w-80">
                    <div class="text-xl font-medium text-black">Task</div>
                    <p class="text-slate-500 text">{{ todo.task }}</p>
                    <p class="select-none">
                        <small v-if="todo.finished" class="text-green-600">Finished <CheckIcon/> - </small>
                        <small v-if="todo.active" class="text-blue-600">Under Progress <StopWatchIcon/> - </small>
                        <small>{{ todo.group.group }}</small>
                    </p>


                </div>
                <div class="ml-auto">
                    <Link :href="route('todos.view',todo.id)" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        <LinkIcon/>
                    </Link>
                    <br>
                    <button @click="destroy(todo.id)" class="mt-2 inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">
                        <TrashIcon/>
                    </button>
                </div>
        </div>
        <div v-if="!todos.data[0]" class="">
            <div class="p-4 m-auto h-auto text-center">
                <h2 class="text-3xl">No Todos Found</h2>
                <Link :href="route('todos.create')" class="mt-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    Create new&nbsp;<PlusIcon/>
                </Link>
            </div>
        </div>
    </div>
    <div class="m-auto text-center w-fit mt-10">
        <Pagination :links="todos.links" />
    </div>
</template>

<script>
import LinkIcon from '@/Icons/Link.vue'
import TrashIcon from '@/Icons/Trash.vue'
import CheckIcon from '@/Icons/Check.vue'
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'
import Pagination from '@/Components/Pagination.vue'
import StopWatchIcon from '@/Icons/StopWatch.vue'
import PlusIcon from '@/Icons/Plus.vue'

export default {
    name: "TodoList",
    components: {
        LinkIcon,
        TrashIcon,
        Link,
        CheckIcon,
        Pagination,
        StopWatchIcon,
        PlusIcon,
    },
    props: {
        todos:Object,
    },
    methods:{
        destroy(id){
            if(confirm('Are you sure you want to delete this task?')) Inertia.delete(route('todos.delete',id));
        }
    },
}
</script>

<style scoped>
.text {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* number of lines to show */
    -webkit-box-orient: vertical;
}
</style>
