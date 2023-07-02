<template>
    <UserLayout :title="todo.task">
        <h2 class="text-2xl">Comments</h2>
        <div class="comments overflow-y-scroll">
            <Comment v-if="allComments[0]" @removeComment="removeComment" v-for="comment in allComments" :data="comment" :user-id="user.id" />
            <h3 class="text-xl m-3 text-center" v-else>No comments found</h3>
            <div class="m-auto text-center my-2">
                <button v-if="comments.next_page_url" @click="loadMoreComments" class="m-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    Load More
                </button>
                <p v-else-if="allComments[0]" class="text-slate-500">All loaded</p>
            </div>
        </div>
        <hr>
        <CommentForm :todo-id="todo.id" />
        <Link :href="route('todos.view',todo.id)" class="m-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Back
        </Link>
    </UserLayout>
</template>

<script>
import UserLayout from '@/Layouts/UserLayout.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import { Link } from '@inertiajs/inertia-vue3';

import Comment from '@/Components/Comment.vue'
import CommentForm from '@/Components/CommentForm.vue'
import { Inertia } from '@inertiajs/inertia'

export default {
    setup() {
        const todo = computed(() => usePage().props.value.todo)
        const user = computed(() => usePage().props.value.auth.user)
        const comments = computed(() => usePage().props.value.comments)
        return {todo, user, comments}
    },
    data() {
        return {
            allComments: this.comments.data,
            initialUrl: this.$page.url,
        }
    },
    name: "Comments",
    components: {
        UserLayout,
        Comment,
        CommentForm,
        Link
    },
    methods: {
        loadMoreComments() {
            if (this.comments.next_page_url === null) {
                return
            }
            Inertia.get(this.comments.next_page_url, {}, {
                preserveState: true,
                preserveScroll: true,
                only: ['comments'],
                onSuccess: () => {
                    this.allComments = [...this.allComments, ...this.comments.data]
                    window.history.replaceState({}, this.$page.title, this.initialUrl)
                }
            })
        },
        removeComment(id) {
            Object.keys(this.allComments).forEach(index => {
                if(this.allComments[index].id == id) delete this.allComments[index]
            })
        }
    }
}
</script>

<style scoped>
.comments {
    max-height: 50vh;
}
</style>
