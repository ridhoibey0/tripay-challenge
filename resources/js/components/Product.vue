<template>
    <div>
        <h5>SKU:</h5>
        <h6>{{ product.sku }}</h6>
        <h5>Name:</h5>
        <p>{{ product.name }}</p>
        <h5>Price:</h5>
        <p>Price: {{ product.price }}</p>
        <router-link
            :to="`/products/${product.id}/edit`"
            class="btn btn-primary"
            >Edit</router-link
        >
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            product: {},
        };
    },
    async created() {
        try {
            const response = await axios.get(
                `/api/products/${this.$route.params.id}`
            );
            this.product = response.data;
        } catch (error) {
            console.error(error);
        }
    },
};
</script>
