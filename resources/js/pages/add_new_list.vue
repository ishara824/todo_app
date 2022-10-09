<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">

                <h2>Add New List</h2>
                <p class="text-danger" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{ err }}</span>
                </p>
                <form @submit.prevent="addNewList">
                    <div class="form-group">
                        <label>Description: </label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control" v-model="form.description"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { reactive,ref } from 'vue';
    import { useRouter } from "vue-router"
    export default {
        setup(){

            const router = useRouter()

            let form = reactive({
                description: ''
            })

            let errors = ref([]);

            const addNewList = async() => {
                await axios.post('/api/create/list',form).then(res=>{
                    if (res.data.success) {
                        router.push({name:'Dashboard'})
                    }
                }).catch(e => {
                    console.log(e)
                    errors.value = e.response.data.message;
                })
            }

            return {
                form,
                addNewList,
                errors
            }
        }
    }
</script>
