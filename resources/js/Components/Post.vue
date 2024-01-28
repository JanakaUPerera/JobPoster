<template>
    <div class="card m-1">
        <div class="card-header flex justify-content-between">
            <div>
                <h5>{{props.post.position}}</h5><p>{{props.post.location}}</p>
            </div>
            <div>
                <p class="text-muted">{{props.post.age}}</p>
                <p>Apply Before Or on {{props.post.deadline}}</p>
            </div>
            <div v-if="props.post.can.update">
                <button type="button" class="btn btn-warning btn-sm" @click.prevent="editPost(props.post)">Edit</button>
            </div>
        </div>
        <div class="card-body">
            <div v-if="!!props.post.about">
                <h6 class="fw-bold">About</h6>
                <p v-html="props.post.about"></p>
                <hr>
            </div>
            <div v-if="!!props.post.responsibilities">
                <h6 class="fw-bold">Responsibilities</h6>
                <p v-html="props.post.responsibilities"></p>
                <hr>
            </div>
            <div v-if="!!props.post.requirements">
                <h6 class="fw-bold">Requirements</h6>
                <p v-html="props.post.requirements"></p>
                <hr>
            </div>
            <div v-if="!!props.post.benefits">
                <h6 class="fw-bold">Benefits</h6>
                <p v-html="props.post.benefits"></p>
                <hr>
            </div>
        </div>
        <div v-if="props.can.application.create" class="card-footer flex justify-content-end">
            <button class="btn btn-secondary">Apply</button>
        </div>
    </div>
</template>

<script setup>
    let props = defineProps(['post','can']);
    const emit = defineEmits(['onEdit'])

    function editPost(post){
        emit('onEdit', post);
    }
</script>

<style scoped>

</style>
