<template>
    <div>
        <h2>{{ isNewProduct ? "Add Product" : "Edit Product" }}</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="sku" class="form-label">SKU:</label>
                <input
                    class="form-control"
                    type="text"
                    id="sku"
                    v-model="product.sku"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input
                    class="form-control"
                    type="text"
                    id="name"
                    v-model="product.name"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input
                    class="form-control"
                    type="number"
                    id="price"
                    v-model="product.price"
                    required
                />
            </div>
            <button type="submit" class="btn btn-primary" :disabled="loading">
                <span v-if="!loading">{{
                    isNewProduct ? "Add Product" : "Update Product"
                }}</span>
                <span v-else>
                    <span
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                    ></span>
                    Loading...
                </span>
            </button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
    data() {
        return {
            product: {
                sku: "",
                name: "",
                price: 0,
            },
            loading: false,
        };
    },
    computed: {
        isNewProduct() {
            return !this.$route.path.includes("edit");
        },
    },
    async created() {
        if (!this.isNewProduct) {
            const response = await axios.get(
                `/api/products/${this.$route.params.id}`
            );
            this.product = response.data;
        }
    },
    methods: {
        async submitForm() {
            try {
                this.loading = true;
                if (this.isNewProduct) {
                    await axios.post("/api/products", this.product);
                } else {
                    await axios
                        .put(
                            `/api/products/${this.$route.params.id}`,
                            this.product
                        )
                        .then((res) => {
                            Swal.fire(
                                "Updated!",
                                "Product has been updated.",
                                "success"
                            );
                        })
                        .catch((err) => {
                            Swal.fire(
                                "ERROR!",
                                "Product not updated.",
                                "error"
                            );
                        });
                }
                this.loading = false;
                this.$router.push("/");
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
