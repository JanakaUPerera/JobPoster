<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {Head, useForm} from '@inertiajs/vue3';
    import {Bootstrap5Pagination} from 'laravel-vue-pagination';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import TextArea from '../Components/TextArea.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    const form = useForm({
        position: '',
        location: '',
        about: '',
        responsibilities: '',
        requirements: '',
        benefits: '',
        deadline: '',
    });

    const submit = () => {
        form.post(route('createPost'), {
            onSuccess: () => window.location = route('job_wall'),
        });
    };
</script>

<template>
    <Head title="Create Job Post"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-content-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Job Post</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="card m-1">
                        <div class="card-body">
                            <form @submit.prevent="submit">
                                <div>
                                    <InputLabel for="position" value="Position"/>
                                    <TextInput
                                        id="position"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.position"
                                        autofocus
                                    />
                                    <InputError class="mt-1" :message="form.errors.position"/>
                                </div>
                                <div class="mt-2">
                                    <InputLabel for="location" value="Location"/>
                                    <TextInput
                                        id="location"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.location"
                                    />
                                    <InputError class="mt-1" :message="form.errors.location"/>
                                </div>
                                <div class="mt-2">
                                    <InputLabel for="about" value="About"/>
                                    <TextArea
                                        id="about"
                                        class="mt-1 block w-full"
                                        v-model="form.about"
                                    />
                                    <InputError class="mt-1" :message="form.errors.about"/>
                                </div>
                                <div class="mt-2">
                                    <InputLabel for="responsibilities" value="Responsibilities"/>
                                    <TextArea
                                        id="responsibilities"
                                        class="mt-1 block w-full"
                                        v-model="form.responsibilities"
                                    />
                                    <InputError class="mt-1" :message="form.errors.responsibilities"/>
                                </div>
                                <div class="mt-2">
                                    <InputLabel for="requirements" value="Requirements"/>
                                    <TextArea
                                        id="requirements"
                                        class="mt-1 block w-full"
                                        v-model="form.requirements"
                                    />
                                    <InputError class="mt-1" :message="form.errors.requirements"/>
                                </div>
                                <div class="mt-2">
                                    <InputLabel for="benefits" value="Benefits"/>
                                    <TextArea
                                        id="benefits"
                                        class="mt-1 block w-full"
                                        v-model="form.benefits"
                                    />
                                    <InputError class="mt-1" :message="form.errors.benefits"/>
                                </div>
                                <div class="mt-2">
                                    <InputLabel for="deadline" value="Last Date"/>
                                    <TextInput
                                        id="deadline"
                                        type="date"
                                        class="mt-1 block w-25"
                                        v-model="form.deadline"
                                    />
                                    <InputError class="mt-1" :message="form.errors.deadline"/>
                                </div>
                                <div class="mt-2 flex justify-content-end">
                                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                                   :disabled="form.processing">
                                        Submit
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
