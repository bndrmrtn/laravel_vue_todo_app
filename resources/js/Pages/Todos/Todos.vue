<template>
    <AppLayout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Todos</h2>
                <div class="ml-auto">
                    <button @click="reload" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        Reload Tasks
                    </button>
                    <Link :href="route('todos.create')" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        Create&nbsp;<PlusIcon/>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <TodoList
                    :todos="todos"
                    :columnNames="['Id','Status','Group','Task']"
                    :dataMapping="{
                                    'Id':'id',
                                    'Status':'current_status',
                                    'Group':'group_name',
                                    'Task':'task',
                                }"
                    class="mx-auto"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import TodoList from '@/Components/TodoList.vue'
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

// icons
import PlusIcon from '@/Icons/Plus.vue'

export default {
    setup() {
        const user = computed(() => usePage().props.value.auth.user)
        const todos = computed(() => usePage().props.value.todos)
        return { user, todos }
    },
    components: {
        TodoList,
        PlusIcon,
        AppLayout,
        Link,
    },
    methods: {
        reload(){
            Inertia.reload();
        }
    }
}
</script>
