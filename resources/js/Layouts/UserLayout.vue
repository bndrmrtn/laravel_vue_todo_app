<template>
    <AppLayout :title="title ? `Todos - ${newtitle}` : 'Todos'">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate">
                {{ title ? `Todos - ${newtitle}` : 'Todos' }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <slot/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
    name: "Layout",
    data(){
        return {
            newtitle:'',
        }
    },
    components: {
        AppLayout
    },
    props: {
        title:String,
    },
    mounted(){
        this.newtitle = this.title
        if(this.title.length > 50) this.newtitle = this.title.substring(0, 50) + '...'
    }
}
</script>

<style scoped>

</style>
