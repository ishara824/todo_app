<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">

                <h2>Register</h2>
                <p class="text-danger" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{ err }}</span>
                </p>
                <form @submit.prevent="register">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" id="first_name" v-model="form.first_name">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" id="last_name" v-model="form.last_name">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" v-model="form.phone_number">
                    </div>
                    <div class="form-group">
                        <label>Email Address: </label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="form-group">
                        <label>Password: </label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password: </label>
                        <input type="password" class="form-control" id="confirm_password" v-model="form.confirm_password">
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { reactive,ref } from 'vue';
    import { useRouter } from "vue-router";
    export default {
        setup(){

            const router = useRouter()

            let form = reactive({
                first_name: '',
                last_name: '',
                phone_number: '',
                email: '',
                password: '',
                confirm_password: ''
            })

            let errors = ref([]);

            const register = async() => {
                await axios.post('/api/register',form).then(res=>{
                    if (res.data.success) {
                        //localStorage.setItem('token',res.data.data.token);
                        router.push({name:'Login'})
                    }
                }).catch(e => {
                    errors.value = e.response.data.message;
                })
            }

            return {
                form,
                register,
                errors
            }
        }
    }
</script>
