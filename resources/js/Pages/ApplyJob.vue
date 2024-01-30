<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {Head, useForm} from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import TextArea from '../Components/TextArea.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    const props = defineProps({
        post: Object
    });

    const form = useForm({
        post_id: 0,
        cover_letter: '',
        cv: null
    });

    const submit = () => {
        form.post_id = props.post.id;
        form.post(route('createApplication'), {
            onSuccess: () => window.location = route('job_wall'),
        });
    }
</script>

<template>
    <Head title="Apply For The Job"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-content-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Apply</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="card m-1">
                        <div class="card-header">
                            <h5>Apply For <i>{{props.post.position}}</i> ~ <span class="text-muted">{{props.post.location}}</span></h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="submit" >
                                <div>
                                    <InputLabel for="cover_letter" value="Cover Letter"/>
                                    <textArea
                                        id="cover_letter"
                                        class="mt-1 block w-full"
                                        v-model="form.cover_letter"
                                        autofocus
                                    />
                                    <InputError class="mt-1" :message="form.errors.cover_letter"/>
                                </div>
                                <div class="mt-2">
                                    <InputLabel for="cv" value="CV"/>
                                    <input class="form-control" id="cv" type="file" @input="form.cv = $event.target.files[0]" />
                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                        {{ form.progress.percentage }}%
                                    </progress>
                                    <InputError class="mt-1" :message="form.errors.cv"/>
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

<style scoped>

</style>
