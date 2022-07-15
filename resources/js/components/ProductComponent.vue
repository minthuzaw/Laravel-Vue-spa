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
                <form action="">
                    <div class="input-group">
                        <input type="text" placeholder="Search" class="form-control">

                        <div class="input-group-append">
                            <button class="btn btn-primary">
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
                        <form @submit.prevent="isEdit ? update() : store()">
                            <div class="form-group my-2">
                                <label>Name :</label>
                                <input v-model="product.name" type="text" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Price : </label>
                                <input v-model="product.price" type="text" inputmode="numeric" class="form-control">
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
                    <tr v-for="product in products" :key="products.id">
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductComponent",

    data() {
        return {
            isEdit: false,
            products: [],
            product: {
                id: '',
                name: '',
                price: ''
            }
        }
    },

    methods: {
        show() {
            axios.get('/api/products')
                .then(response => {
                    this.products = response.data
                })
                .catch(error => {
                    console.log(error)
                });
        },

        create() {
            this.isEdit = false;
            this.product.id = '';
            this.product.name = '';
            this.product.price = '';
        },

        store() {
            axios.post('/api/products', this.product)
                .then(response => {
                    this.show();
                    this.product.id = '';
                    this.product.name = '';
                    this.product.price = '';
                });
        },

        edit(product) {
            this.isEdit = true;
            this.product.id = product.id;
            this.product.name = product.name;
            this.product.price = product.price;
        },

        update() {
            axios.put(`/api/products/${this.product.id}`, this.product)
                .then(response => {
                    this.show();
                    this.product.id = '';
                    this.product.name = '';
                    this.product.price = '';
                    this.isEdit = false;
                })
                .catch(error => {

                })
        },

        destroy(id) {
            if (! confirm('Are sure to delete?')){
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
