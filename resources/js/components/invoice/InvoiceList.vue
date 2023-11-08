<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Merchant Ref</th>
                    <th scope="col">Tripay References</th>
                    <th scope="col">Buyer Email</th>
                    <th scope="col">Buyer Phone</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Checkout Url</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(invoice, index) in invoices" :key="invoice.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ invoice.product.name }}</td>
                    <td>{{ invoice.merchant_ref }}</td>
                    <td>{{ invoice.tripay_references }}</td>
                    <td>{{ invoice.buyer_email }}</td>
                    <td>{{ invoice.buyer_phone }}</td>
                    <td>{{ invoice.payment_status }}</td>
                    <td>{{ invoice.checkout_url }}</td>
                    <td>
                        <div class="row gap-3">
                            <router-link
                                :to="`/invoices/${invoice.id}`"
                                class="p-2 col border btn btn-primary"
                                >View</router-link
                            >
                            <button
                                @click="deleteProduct(invoice.id)"
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
            invoices: [],
        };
    },
    async created() {
        try {
            const response = await axios.get("/api/invoices");
            this.invoices = response.data;
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
                            .delete(`/api/invoices/${id}`)
                            .then((res) => {
                                Swal.fire(
                                    "Deleted!",
                                    "Product has been deleted.",
                                    "success"
                                );
                                this.invoices = this.invoices.filter(
                                    (invoice) => invoice.id !== id
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
