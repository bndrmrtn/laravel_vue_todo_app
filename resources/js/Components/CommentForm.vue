<template>
    <form action="" v-on:submit.prevent>
        <div class="justify-center mt-4 flex">
            <div>
                <input
                    class="bg-gray-200 rounded-r-none  appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                    type="text"
                    placeholder="New Comment"
                    v-model.lazy="form.comment"
                />
            </div>
            <div>
                <button @click="submit" class="inline-flex rounded-l-none items-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    Submit
                </button>
            </div>
        </div>
        <div class="text-red-700 text-center" v-if="form.errors.comment">{{ form.errors.comment }}</div>
    </form>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    setup(){
        const form = useForm({
            comment: '',
        })
        return { form }
    },
    props: {
      todoId:Number,
    },
    name: "CommentForm",
    methods: {
        submit(){
            this.form.post(route('comments.create',this.todoId))
            this.form.reset()
        },
    }
}
</script>

<style scoped>

</style>
