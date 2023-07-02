<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Dash
                        :active-todos="actives"
                        :timelogs="daily_activity"
                        :group-count="group_count"
                        :highest-priority="highest_priority"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Dash from '@/Components/Dash.vue';
import {computed} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";

export default {
    setup() {
        const actives = computed(() => usePage().props.value.active_todos)
        const daily_activity = computed(() => usePage().props.value.daily_activity)
        const group_count = computed(() => usePage().props.value.group_count)
        const highest_priority = computed(() => usePage().props.value.highest_priority)
        return { actives, daily_activity, group_count, highest_priority }
    },
    name: "TodoDash",
    components: {
        AppLayout,
        Dash
    }
}
</script>

<style scoped>

</style>
