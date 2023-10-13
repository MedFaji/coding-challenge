<template>
    <div>
        <div class="d-flex justify-content-between">
            <div>
                <h3>Products</h3>
            </div>
            <div>
                <input class="form-control me-2" v-model="searchQuery" @input="searchProducts" placeholder="Search products" aria-label="Search">
            </div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Categories</th>
                <th scope="col">Price</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products.data" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td >
                    <ul >
                        <li v-for="category in product.categories" >{{category.name}}</li>
                    </ul>
                </td>

                <td>{{ product.price }}</td>
                <td>
                    <div class="row gap-3">
                        <router-link :to="`/products/${product.id}`" class="p-2 col border btn btn-primary">View</router-link>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-5"><Bootstrap5Pagination
        :data="products"
        @pagination-change-page="fetchProducts"
    /></div>



</template>
<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';


const products = ref([]);
const searchQuery = ref('');

const searchProducts = async (page = 1) => {
    try {
        const response = await axios.get(`/api/products/search?page=${page}`, {
            params: {
                s: searchQuery.value,
            },
        });
        products.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

const fetchProducts = async (page = 1) => {
    try {
        const response = await axios.get(`/api/products?page=${page}`);
        products.value = response.data;

    } catch (error) {
        console.error(error);
    }
};


onMounted( () => {
    fetchProducts();

});

</script>
