<template>
    <div>
        <div class="row">
            <h2>Choose your payment methods</h2>
            <div class="col-3" v-for="payment in payments" :key="payment.id">
                <button class="payment-button" @click="handleSubmit(payment)">
                    <img :src="payment.icon_url" class="payment-image" alt="" />
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Add styles to your Vue component */
.payment-button {
    background-color: #fff;
    padding: 1rem;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
}

.payment-button:hover {
    transform: scale(1.05);
}

.payment-image {
    width: 80px;
    height: 80px;
    object-fit: contain;
}
</style>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
    data() {
        return {
            payments: [],
        };
    },
    async created() {
        try {
            const response = await axios.get(`/api/getPayment/`);
            this.payments = response.data.data;
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        async handleSubmit(payment) {
            const data = {
                product_id: this.$route.params.id,
                method: payment.code,
            };

            try {
                const res = await axios.post("/api/invoices", data);

                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Transaction has been successfully, you will be redirected to the payment page",
                    timer: 5000, // Keep the success message open for 5 seconds
                    showConfirmButton: false,
                });

                setTimeout(() => {
                    window.location.href = res.data.data.checkout_url;
                }, 5000);

                console.log(res);
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Something went wrong.",
                });
                console.error(error);
            }
        },
    },
};
</script>
