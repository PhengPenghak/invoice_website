<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router"; // Import useRouter for navigation

// Get the router instance
const router = useRouter();

// State variables
let invoices = ref([]);
let searchInvoice = ref("");

// Fetch all invoices on component mount
onMounted(async () => {
    await getInvoices();
});

// Fetch all invoices
const getInvoices = async () => {
    try {
        let response = await axios.get("/api/get_all_invoice");
        invoices.value = response.data.invoices;
    } catch (error) {
        console.error("Error fetching invoices:", error);
    }
};

// Search invoices based on input
const searchInvoices = async () => {
    try {
        let response = await axios.get(
            `/api/search_invoice?s=${searchInvoice.value}`
        );
        invoices.value = response.data.invoices;
    } catch (error) {
        console.error("Error searching invoices:", error);
    }
};

// Navigate to the create invoice form
const createInvoice = () => {
    router.push("/invoice/create"); // Adjust this route to match your route structure
};
</script>

<template>
    <div class="container">
        <div class="invoices">
            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Invoices</h2>
                </div>
                <div>
                    <a class="btn btn-secondary" @click="createInvoice">
                        New Invoice
                    </a>
                </div>
            </div>

            <div class="table card__content">
                <div class="table--filter">
                    <span class="table--filter--collapseBtn">
                        <i class="fas fa-ellipsis-h"></i>
                    </span>
                    <div class="table--filter--listWrapper">
                        <ul class="table--filter--list">
                            <li>
                                <p
                                    class="table--filter--link table--filter--link--active"
                                >
                                    All
                                </p>
                            </li>
                            <li>
                                <p class="table--filter--link">Paid</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table--search">
                    <div class="table--search--wrapper">
                        <select class="table--search--select" name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="relative">
                        <i class="table--search--input--icon fas fa-search"></i>
                        <input
                            v-model="searchInvoice"
                            @input="searchInvoices"
                            class="table--search--input"
                            type="text"
                            placeholder="Search invoice"
                        />
                    </div>
                </div>

                <div class="table--heading">
                    <p>ID</p>
                    <p>Date</p>
                    <p>Number</p>
                    <p>Customer</p>
                    <p>Due Date</p>
                    <p>Total</p>
                </div>

                <!-- Invoice Items -->
                <div
                    class="table--items"
                    v-for="item in invoices"
                    :key="item.id"
                >
                    <a href="#" class="table--items--transactionId"
                        >#{{ item.id }}</a
                    >
                    <p>{{ item.date }}</p>
                    <p>#{{ item.number }}</p>
                    <p v-if="item.customer">{{ item.customer.first_name }}</p>
                    <p v-else>No customer information available</p>
                    <p>{{ item.due_date }}</p>
                    <p>${{ item.total }}</p>
                </div>
                <div class="table--items" v-if="invoices.length === 0">
                    <p>Invoice not found</p>
                </div>
            </div>
        </div>
    </div>
</template>
