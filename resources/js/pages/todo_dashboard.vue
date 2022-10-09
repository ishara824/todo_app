<template>
    <div class="container">
        <div class="row col-md-12">
            <div class="col-md-4 text-left mt-2"><h2>Dashboard, Hi {{fname}} </h2></div>

            <div class="col-md-8 text-right">
                <button type="button" class="btn btn-primary mt-2 mr-2" @click="addNewList">Add ToDo+</button>
                <button type="button" class="btn btn-dark mt-2" @click="logout">Logout</button>
            </div>

        </div>

        <table class="table table-responsive col-md-12 mt-4">
            <thead class="thead-dark">
                <tr>
                    <th width="100">#</th>
                    <th width="500">Description</th>
                    <th class="text-center" width="400">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list, index) in todo_list" :key="list">
                    <td>{{index + 1}}</td>
                    <td>{{list.description}}</td>
                    <td class="text-center">
                        <router-link :to="{path: '/new/item/'+list.id}" style="width: 100px" tag="button" class="btn btn-sm btn-primary">Add Item</router-link>
                        <button class="btn btn-sm btn-secondary ml-2" style="width: 100px" @click="loadTodoItems(list.id)">View</button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Todo Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th class="text-center" width="300">Title</th>
                                <th class="text-center" width="150">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in todo_items" :key="item">
                                <td>{{index + 1}}</td>
                                <td>{{item.item_description}}</td>
                                <td>
                                    <span v-show="item.status == 1" style="color: orange">PENDING</span>
                                    <span v-show="item.status == 2" style="color: green">COMPLETED</span>
                                    <span v-show="item.status == 0" style="color: red">DELETED</span>
                                </td>
                                <td v-show="item.status == 0">
                                    <button class="btn btn-sm btn-primary" disabled>Update</button>
                                    <button class="btn btn-sm btn-danger ml-2" disabled>Delete</button>
                                    <button class="btn btn-sm btn-success ml-2" disabled>Complete</button>
                                </td>
                                <td v-show="item.status == 1">
                                    <router-link :to="{path: '/update/task/'+item.id}" tag="button" class="btn btn-sm btn-primary" data-dismiss="modal">Update</router-link>
                                    <button class="btn btn-sm btn-danger ml-2" @click="deleteTask(item.id)">Delete</button>
                                    <button v-show="item.status == 1" class="btn btn-sm btn-success ml-2" @click="completeTask(item.id)">Complete</button>
                                </td>
                                <td v-show="item.status == 2">
                                    <button class="btn btn-sm btn-primary" disabled>Update</button>
                                    <button class="btn btn-sm btn-danger ml-2" disabled>Delete</button>
                                    <button class="btn btn-sm btn-success ml-2" disabled>Complete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import { useRouter } from "vue-router"
    import { ref } from 'vue';

    export default {
        setup() {
            const router = useRouter();

            function logout() {
                localStorage.removeItem('token');
                router.push({name:'Home'})
            }
            function addNewList() {
                router.push({name:'List'})
            }

            let fname = ref('');
            let todo_items = ref([]);

            function loadTodoItems(list_id) {
                axios.post('/api/get/all/items',{list_id: list_id}).then(res=>{
                    console.log(res.data);
                    todo_items.value = res.data;
                    $('#exampleModal').modal('show');
                })
            }

            let todo_list = ref([]);

            axios.get('/api/get/all/lists').then(res=>{
                console.log(res);
                todo_list.value = res.data;
            })

            axios.get('/api/user').then(res=>{
                fname.value = res.data.first_name;
                console.log(fname);
            })

            return {
                logout,
                addNewList,
                todo_list,
                loadTodoItems,
                todo_items,
                fname
            }
        },
        methods: {
            completeTask(item_id) {
                axios.post('/api/complete/todo',{item_id: item_id}).then(res => {
                    Swal.fire(
                        'Good job!',
                        'Task Completed',
                        'success'
                    )
                })

            },

            deleteTask(item_id) {
                axios.post('/api/delete/todo',{item_id: item_id}).then(res => {
                    Swal.fire(
                        'Good job!',
                        'Task Deleted',
                        'success'
                    )
                })
            }
        }
    }
</script>
