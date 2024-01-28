<script setup>
    import {ref} from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {Head, useForm} from '@inertiajs/vue3';
    import {Bootstrap5Pagination} from 'laravel-vue-pagination';
    import Post from '../Components/Post.vue'
    import Modal from '../Components/Modal.vue'
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import TextArea from '../Components/TextArea.vue';

    let props = defineProps({
        posts: Object,
        paginate: Object,
        can: Object
    });

    const showEditModel = ref(false);

    const updateForm = useForm({
        position: '',
        location: '',
        about: '',
        responsibilities: '',
        requirements: '',
        benefits: '',
        deadline: '',
        id: 0,
    });

    function postPaginate(page = 1) {
        // Construct the new URL with parameters
        const newUrl = `${window.location.pathname}?page=${page}`;

        // Update the URL
        window.history.replaceState({}, '', newUrl);

        // Force a page reload
        window.location.reload();
    }

    function createPost() {
        window.location = route('loadCreatePost');
    }

    function closeUpdateModal() {
        showEditModel.value = false;
        updateForm.reset();
    }

    const edit = (post) => {
        updateForm.position = post.position;
        updateForm.location = post.location;
        updateForm.about = post.about;
        updateForm.responsibilities = post.responsibilities;
        updateForm.requirements = post.requirements;
        updateForm.benefits = post.benefits;
        updateForm.deadline = post.deadline;
        updateForm.id = post.id;
        showEditModel.value = true;
    }

    const updateSubmit = () => {
        updateForm.post(route('updatePost'), {
            onSuccess: () => window.location = route('job_wall')
        })
    }
</script>

<template>
    <Head title="Job Wall"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-content-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Job Wall</h2>
                <button v-if="props.can.post.create" class="btn btn-primary" @click="createPost">Create a Job Post
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-for="post in props.posts">
                        <Post @onEdit="edit" :post="post" :can="props.can"></Post>
                    </div>

                    <Bootstrap5Pagination class="m-1" :data="props.paginate" @pagination-change-page="postPaginate"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="showEditModel" @close="closeUpdateModal" maxWidth="w-75">
        <div class="card">
            <div class="card-header flex justify-content-between">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Post</h1>
                <button type="button" class="btn-close" aria-label="Close"
                        @click="closeUpdateModal"></button>
            </div>
            <form @submit.prevent="updateSubmit">
                <div class="card-body">
                    <div>
                        <InputLabel for="position" value="Position"/>
                        <TextInput
                            id="position"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="updateForm.position"
                            autofocus
                        />
                        <InputError class="mt-1" :message="updateForm.errors.position"/>
                    </div>
                    <div class="mt-2">
                        <InputLabel for="location" value="Location"/>
                        <TextInput
                            id="location"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="updateForm.location"
                        />
                        <InputError class="mt-1" :message="updateForm.errors.location"/>
                    </div>
                    <div class="mt-2">
                        <InputLabel for="about" value="About"/>
                        <TextArea
                            id="about"
                            class="mt-1 block w-full"
                            v-model="updateForm.about"
                        />
                        <InputError class="mt-1" :message="updateForm.errors.about"/>
                    </div>
                    <div class="mt-2">
                        <InputLabel for="responsibilities" value="Responsibilities"/>
                        <TextArea
                            id="responsibilities"
                            class="mt-1 block w-full"
                            v-model="updateForm.responsibilities"
                        />
                        <InputError class="mt-1" :message="updateForm.errors.responsibilities"/>
                    </div>
                    <div class="mt-2">
                        <InputLabel for="requirements" value="Requirements"/>
                        <TextArea
                            id="requirements"
                            class="mt-1 block w-full"
                            v-model="updateForm.requirements"
                        />
                        <InputError class="mt-1" :message="updateForm.errors.requirements"/>
                    </div>
                    <div class="mt-2">
                        <InputLabel for="benefits" value="Benefits"/>
                        <TextArea
                            id="benefits"
                            class="mt-1 block w-full"
                            v-model="updateForm.benefits"
                        />
                        <InputError class="mt-1" :message="updateForm.errors.benefits"/>
                    </div>
                    <div class="mt-2">
                        <InputLabel for="deadline" value="Last Date"/>
                        <TextInput
                            id="deadline"
                            type="date"
                            class="mt-1 block w-25"
                            v-model="updateForm.deadline"
                        />
                        <InputError class="mt-1" :message="updateForm.errors.deadline"/>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="flex justify-content-end">
                        <button type="button" class="btn btn-secondary" @click="closeUpdateModal">
                            Close
                        </button>
                        <button :class="[{ 'opacity-25': updateForm.processing }, 'ml-2']"
                                :disabled="updateForm.processing" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
