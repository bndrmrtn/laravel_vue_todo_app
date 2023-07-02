<template>
    <form @submit.prevent="submit">
        <h2 class="text-xl m-2 mb-5">{{ !todo ? 'Create' : 'Update' }} todo</h2>

        <div class="md:flex mx-auto">

            <div class="m-2">
                <p>Group</p>
                <select v-model.lazy="form.group_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option v-for="group in groups" :key="group.id" :value="group.id">{{ group.group }}</option>
                </select>
                <div v-if="form.errors.group_id">{{ form.errors.group_id }}</div>
            </div>

            <div class="m-2">
                <p>Current Status</p>
                <select v-model.lazy="form.current_status_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option v-for="status in statuses" :key="status.id" :value="status.id">{{ status.name }}</option>
                </select>
                <div v-if="form.errors.current_status_id">{{ form.errors.current_status_id }}</div>
            </div>

            <div class="m-2">
                <p>Priority</p>
                <select v-model.lazy="form.priority" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option v-for="num in Array(10).keys()" :key="num" :value="num">{{ num + 1 }}</option>
                </select>
                <div v-if="form.errors.priority">{{ form.errors.priority }}</div>
            </div>

        </div>

        <div class="m-2">
            <p>Task</p>
            <textarea v-model.lazy="form.task" type="text" placeholder="Task..." class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
            <div v-if="form.errors.task">{{ form.errors.task }}</div>
        </div>

        <button :disabled="form.processing" class="m-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            {{ todo ? 'Update' : 'Create' }}
        </button>

        <Link :href="route('todos')" class="m-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Back
        </Link>
    </form>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    setup(){
        const form = useForm({
            group_id: null,
            current_status_id: null,
            task: '',
            priority:0,
        })

        return { form }
    },
    name: "TodoForm",
    props: {
        groups:Object,
        statuses:Object,
        todo:Object,
    },
    components: {
        Link,
    },
    methods: {
        submit(){
            if(this.todo) {
                this.form.put(route('todos.update',this.todo.id))
            } else {
                this.form.post(route('todos.store'))
            }
            this.form.reset()
        }
    },
    mounted(){
        if(!this.todo){
            this.form.group_id = this.groups[0].id
            this.form.current_status_id = this.statuses[0].id
        } else {
            this.form.group_id = this.todo.group.id
            this.form.current_status_id = this.todo.status.id
            this.form.task = this.todo.task
            this.form.priority = this.todo.priority
        }
    }
}
</script>

<style scoped>

</style>
