<template>
    <div class="row ">
        <div class="col">
            <h5 id="associating-form-text-with-form-controls">Name:</h5>
            <h6>{{ product.name }}</h6>
            <h5 id="associating-form-text-with-form-controls">Description:</h5>
            <p>{{ product.description }}</p>
            <h5 id="associating-form-text-with-form-controls">Price:</h5>
            <p>Price: {{ product.price }}</p>
            <h5 id="associating-form-text-with-form-controls">Categories:</h5>
            <ul >
                <li v-for="category in product.categories">{{ category.name }}</li>
            </ul>
        </div>

        <div v-if="product.image" class="col">

            <img :src="product.image" alt="Product Image" height="300">
        </div>

    </div>
</template>

<script setup>
import axios from 'axios';
import {ref, onMounted} from 'vue';
import {useRoute} from "vue-router";

const product = ref({});
const route = useRoute();

onMounted(async () => {
    try {
        const response = await axios.get(`/api/products/${route.params.id}`);
        product.value = response.data;

    } catch (error) {
        console.error(error);
    }
});
</script>
