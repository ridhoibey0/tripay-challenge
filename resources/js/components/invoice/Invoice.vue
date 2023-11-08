<template>
    <div>
        <h5>Product Name:</h5>
        <h6>{{ invoice.product.name }}</h6>
        <h5>Merchant References:</h5>
        <p>{{ invoice.merchant_ref }}</p>
        <h5>Tripay References:</h5>
        <p>{{ invoice.tripay_references }}</p>
        <h5>Buyer Email:</h5>
        <p>Buyer Email: {{ invoice.buyer_email }}</p>
        <h5>Buyer Phone:</h5>
        <p>Buyer Phone: {{ invoice.buyer_phone }}</p>
        <h5>Payment status:</h5>
        <p>Payment status: {{ invoice.payment_status }}</p>
        <div v-if="invoice.payment_status !== 'PAID'">
            <h5>Checkout Url:</h5>
            <p>Checkout Url: {{ invoice.checkout_url }}</p>
            <a
                :href="invoice.checkout_url"
                target="_blank"
                class="btn btn-success"
                >Bayar</a
            >
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            invoice: {},
        };
    },
    async created() {
        try {
            const response = await axios.get(
                `/api/invoices/${this.$route.params.id}`
            );
            this.invoice = response.data;
            console.log(this.invoice);
        } catch (error) {
            console.error(error);
        }
    },
};
</script>
