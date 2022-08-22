<template>
    <div class="container my-5">
        <div class="row my-2 justify-content-end">
            <div class="col-md-5">
                <!--create-button-->
                <button class="btn btn-primary" @click="create">
                    <i class="fas fa-plus-circle"></i> Create
                </button>
            </div>
            <div class="col-md-4">
                <form @submit.prevent="show">
                    <div class="input-group">
                        <input type="text" v-model="search" placeholder="Search" class="form-control">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
        <div class="row">
            <div class="col-md-3">
                <!--create-->
                <div class="card">
                    <h3 class="card-header">
                        {{ isEdit ? 'Edit' : 'Create' }}
                    </h3>
                    <div class="card-body">
                        <AlertError :form="product" :message="errorMessage" />

                        <form @submit.prevent="isEdit ? update() : store()" @keydown="product.onKeydown($event)">
                            <div class="form-group my-2">
                                <label>Name :</label>
                                <input v-model="product.name" type="text" name="name" class="form-control"
                                :class="{ 'is-invalid' : product.errors.has('name') }">
                                 <HasError :form="product" field="name"/>
                            </div>

                            <div class="form-group">
                                <label>Price : </label>
                                <input v-model="product.price" type="text" inputmode="numeric" class="form-control"
                                :class="{ 'is-invalid' : product.errors.has('price') }"/>
                                <has-error :form="product" field="price"></has-error>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary mt-3" type="submit">
                                    <i class="fas fa-save"></i> {{ isEdit ? 'Update' : 'Save' }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in products.data" :key="products.id">
                        <td>{{ product.id }}</td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.price }}</td>
                        <td>
                            <button class="btn btn-success btn-sm" @click="edit(product)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" @click="destroy(product.id)">
                                <i class="fas fa-trash-can "></i> Delete
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <sliding-pagination
                    :current="currentPage"
                    :total="totalPages"
                    @page-change="show"
                ></sliding-pagination>
            </div>
        </div>
    </div>
</template>

<script>
import SlidingPagination from 'vue-sliding-pagination'
import Form from 'vform'

export default {
    name: "ProductComponent",
    components: {SlidingPagination},

    data() {
        return {
            currentPage: 1,
            totalPages: 10,
            search: '',
            isEdit: false,
            products: {},
            product: new Form({
                id: '',
                name: '',
                price: ''
            }),
            errorMessage: '',
        }
    },

    methods: {
        show(page = 1) {
            this.$Progress.start()
            axios.get(`/api/products?page=${page}&search=${this.search}`)
                .then(response => {
                    this.products = response.data
                    this.$Progress.finish()
                })
                .catch(error => {
                    this.$Progress.fail()
                    console.log(error)
                });
        },

        create() {
            this.product.clear();
            this.isEdit = false;
            // this.product.id = '';
            // this.product.name = '';
            // this.product.price = '';
            this.product.reset();
        },

        store() {
            this.product.post('/api/products')
                .then(response => {
                    this.show();
                    // this.product.id = '';
                    // this.product.name = '';
                    // this.product.price = '';
                    this.product.reset();
                })
                .catch(error => {
                    // console.log(error.response.data.message);
                    this.errorMessage = error.response.data.message;
                });

        },

        edit(product) {
            this.product.clear();
            this.isEdit = true;
            this.product.fill(product);
            // this.product.id = product.id;
            // this.product.name = product.name;
            // this.product.price = product.price;
        },

        update() {
            this.product.put(`/api/products/${this.product.id}`)
                .then(response => {
                    this.show();
                    // this.product.id = '';
                    // this.product.name = '';
                    // this.product.price = '';
                    this.product.reset();
                    this.isEdit = false;
                })
                .catch(error => {

                })
        },

        destroy(id) {
            if (!confirm('Are sure to delete?')) {
                return;
            }

            axios.delete(`/api/products/${id}`)
                .then(response => this.show());
        }
    },

    created() {
        this.show();
    },
}
</script>
