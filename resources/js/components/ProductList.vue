<template>
    <div>
        <div class="d-flex justify-content-between">
            <div>
                <h3>Products</h3>
                <button @click="sortByName" class="btn btn-light my-2">Sort by Name</button>
                <button @click="sortByPrice" class="btn btn-light">Sort by Price</button>
            </div>
            <div>
                <input class="form-control me-2" v-model="searchQuery" @input="fetchData" placeholder="Search products" aria-label="Search">
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
        @pagination-change-page="fetchData"
    /></div>



</template>
<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const products = ref([]);
const searchQuery = ref('');
const sortBy = ref('');

const fetchData = async (page = 1) => {
    try {
        let requestUrl = `/api/products?page=${page}`;

        if (searchQuery.value || sortBy.value) {
            // Add the search query if it exists.
            if (searchQuery.value) {
                requestUrl += `&s=${searchQuery.value}`;
            }

            // Add the sorting criteria if it exists.
            if (sortBy.value) {
                requestUrl += `&sort_by=${sortBy.value}`;
            }
        }
        const response = await axios.get(requestUrl);
        products.value = response.data;

    } catch (error) {
        console.error(error);
    }
};

const sortByName = () => {
    sortBy.value = 'name';
    fetchData();
};

const sortByPrice = () => {
    sortBy.value = 'price';
    fetchData();
};

onMounted(() => {
    fetchData();
});
</script>
