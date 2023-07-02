<template>
    <div class="flex m-4 sm:max-w-md max-w-7xl mx-auto">
        <div class="flex-shrink-0 mr-3">
            <img class="mt-2 rounded-full w-8 h-8 sm:w-10 sm:h-10" :src="data.user.profile_photo_url" :alt="data.user.name">
        </div>
        <div class="flex-1 border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
            <strong>{{ data.user.name }}</strong> <span class="text-xs text-gray-400">{{ getAgo(data.created_at) }}</span>
            <p class="text-sm">
                {{ data.comment }}
            </p>
            <button @click="deleteComment(data.id)" class="text-slate-500 underline hover:text-slate-600 transition text-sm" v-if="userId == data.user.id">
                Delete
            </button>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'

export default {
    name: "Comment",
    props: {
        data:Object,
        userId:Number,
    },
    methods: {
        getAgo(date){
            return this.ago(new Date(date))
        },
        deleteComment(id){
            if(confirm('Are you sure you want to delete this comment?')) Inertia.delete(route('comments.delete',id))
            this.$emit('removeComment',id)
        },
    }
}
</script>

<style scoped>

</style>
