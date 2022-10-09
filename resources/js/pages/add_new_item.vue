
    <template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 mt-4">

                    <h2>Add New Todo Item</h2>
                    <p class="text-danger" v-for="error in errors" :key="error">
                        <span v-for="err in error" :key="err">{{ err }}</span>
                    </p>

                    <form @submit.prevent="saveItem">

                        <div class="form-group">
                            <label>Description: </label>
                            <input type="text" name="item_description" id="item_description" class="form-control" v-model="form.item_description">
                        </div>
                        <div class="form-group">
                            <label>Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" v-model="form.due_date">
                        </div>
                        <div class="form-group">
                            <label>Due Time</label>
                            <input type="time" name="due_time" id="due_time" class="form-control" v-model="form.due_time">
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>

                    </form>
                </div>
            </div>
        </div>

    </template>

    <script>

        import { reactive,ref } from 'vue';
        import { useRouter,useRoute } from "vue-router";

        export default {
            setup() {

                const router = useRouter();

                const route = useRoute();

                let form = reactive({
                    item_description: '',
                    due_date: '',
                    due_time: '',
                    todo_list_id: route.params.id
                })

                console.log(form)

                let errors = ref([]);

                const saveItem = async() => {
                    await axios.post('/api/create/item',form).then(res=>{
                        if (res.data.success) {
                            console.log(res);
                            router.push({name:'Dashboard'})
                        }
                    }).catch(e => {
                        errors.value = e.response.data.message;
                    })
                }

                return {
                    form,
                    errors,
                    saveItem
                }
            }
        }

    </script>



