<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">SKU</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.id }}</td>
                    <td>{{ product.sku }}</td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.price.toLocaleString() }}</td>
                    <td>
                        <div class="row gap-3">
                            <router-link
                                :to="`/checkout/${product.id}/payment`"
                                class="p-2 col border btn btn-warning"
                                >Buy</router-link
                            >
                            <router-link
                                :to="`/products/${product.id}`"
                                class="p-2 col border btn btn-primary"
                                >View</router-link
                            >
                            <router-link
                                :to="`/products/${product.id}/edit`"
                                class="p-2 col border btn btn-success"
                                >Edit</router-link
                            >
                            <button
                                @click="deleteProduct(product.id)"
                                type="button"
                                class="p-2 col border btn btn-danger"
                            >
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
    data() {
        return {
            products: [],
        };
    },
    async created() {
        try {
            const response = await axios.get("/api/products");
            this.products = response.data;
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        async deleteProduct(id) {
            try {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then(async (result) => {
                    if (result.value) {
                        await axios
                            .delete(`/api/products/${id}`)
                            .then((res) => {
                                Swal.fire(
                                    "Deleted!",
                                    "Product has been deleted.",
                                    "success"
                                );
                                this.products = this.products.filter(
                                    (product) => product.id !== id
                                );
                            })
                            .catch((err) => {
                                Swal.fire(
                                    "ERROR!",
                                    "Product not deleted.",
                                    "error"
                                );
                            });
                    }
                });
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
