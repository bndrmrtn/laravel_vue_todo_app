<template>
    <UserLayout title="Create">
        <TodoForm
        :groups="groups"
        :statuses="statuses"
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
        return { groups, statuses }
    },
    name: "Create",
    components: {
        UserLayout,
        TodoForm,
    },
}
</script>

<style scoped>

</style>
