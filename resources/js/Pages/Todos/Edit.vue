<template>
    <UserLayout title="Edit">
        <TodoForm
            :groups="groups"
            :statuses="statuses"
            :todo="todo"
        />
    </UserLayout>
</template>

<script>
import UserLayout from '@/Layouts/UserLayout.vue'
import TodoForm from '@/Components/TodoForm.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

export default {
    setup() {
        const groups = computed(() => usePage().props.value.groups)
        const statuses = computed(() => usePage().props.value.statuses)
        const todo = computed(() => usePage().props.value.todo)
        return { groups, statuses, todo }
    },
    name: "Edit",
    components: {
        UserLayout,
        TodoForm,
    },
}
</script>

<style scoped>

</style>
