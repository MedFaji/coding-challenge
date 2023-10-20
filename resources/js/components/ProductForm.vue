<template>
    <div>
        <h2 >Add Product</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input class="form-control" type="text" id="name" v-model="product.name" required />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" v-model="product.description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input class="form-control" type="number" step=0.01 id="price" v-model="product.price" required />
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input class="form-control" type="file" id="image" @change="handleFileChange"  />

                <img v-if="ProductPictureUrl" class="mt-4" style="width: 200px; height: 200px" :src="ProductPictureUrl">
            </div>
            <div class="mb-3">
                <label for="categories" class="form-label">Categories:</label>
                <select class="form-control" id="categories" v-model="selectedCategories" multiple>
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>

        </form>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from "vue-router";

const product = ref({
    name: '',
    description: '',
    price: 0,
    image: null,
    category_ids: []
});

const categories = ref([]);
const selectedCategories = ref([]); // Initialize an empty array for selected categories

const route = useRoute();
const router = useRouter();
const ProductPictureUrl = ref(null);

const handleFileChange = (e) => {
    const file = e.target.files[0];
    ProductPictureUrl.value = URL.createObjectURL(file);
    product.value.image = file;
}


async function submitForm() {
    try {
        const formData = new FormData();
        formData.append('name', product.value.name);
        formData.append('description', product.value.description);
        formData.append('price', product.value.price);
        formData.append('image', product.value.image); // Append the image file

        // Append the selected category IDs
        selectedCategories.value.forEach((categoryId) => {
            formData.append('category_ids[]', categoryId);
        });

        await axios.post('/api/products', formData, {
            headers: {
                'Content-Type': 'multipart/form-data', // Set the correct content type for file uploads
            },
        });

        await router.push('/');
    } catch (error) {
        console.error(error);
    }
}

onMounted(async () => {

    const categoriesResponse = await axios.get('/api/categories');
    categories.value = categoriesResponse.data;

});
</script>
