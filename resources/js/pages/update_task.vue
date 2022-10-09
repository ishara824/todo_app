<template>
    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 mt-4">

                    <h2>Update Todo Item</h2>
                    <p class="text-danger" v-for="error in errors" :key="error">
                        <span v-for="err in error" :key="err">{{ err }}</span>
                    </p>

                    <form @submit.prevent="updateTask">

                        <div class="form-group">
                            <label>Description: </label>
                            <input type="text" name="item_description" id="item_description" class="form-control" v-model="item_detail.item_description">
                        </div>
                        <div class="form-group">
                            <label>Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" v-model="item_detail.due_date">
                        </div>
                        <div class="form-group">
                            <label>Due Time</label>
                            <input type="time" name="due_time" id="due_time" class="form-control" v-model="item_detail.due_time">
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { useRoute,useRouter } from "vue-router"
    import { ref } from 'vue';

    export default {
        data() {

            return {
                item_detail: '',
                errors: []
            }

        },

        mounted() {

            const route = useRoute();

            console.log(route.params.id);

            //let item_detail = ref([]);

            axios.get('/api/get/item/details/'+route.params.id).then(res => {
                this.item_detail = res.data
            });

        },

        methods: {
            updateTask() {
                axios.post('/api/update/task',this.item_detail).then(res => {
                    console.log(res);
                    if (res.status == 200) {
                        Swal.fire(
                            'Good job!',
                            'Task Updated Successfully!',
                            'success'
                        )
                    }
                }).catch(e => {
                    console.log(e.response);
                    this.errors = e.response.data.message;
                });
            }
        }
    }
</script>
