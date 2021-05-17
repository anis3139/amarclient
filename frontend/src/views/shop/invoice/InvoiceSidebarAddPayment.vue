<template>
  <b-sidebar
    id="sidebar-invoice-add-payment"
    sidebar-class="sidebar-lg"
    bg-variant="white"
    shadow
    backdrop
    no-header
    right
  >
    <template #default="{ hide }">
      <!-- Header -->
      <div
        class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1"
      >
        <h5 class="mb-0">Add Payment</h5>

        <feather-icon class="ml-1 cursor-pointer" icon="XIcon" size="16" @click="hide" />
      </div>

      <!-- Body -->
      <b-form class="p-2" @submit.prevent>
        <!-- Invoice Balance -->
        <b-form-group label="Invoice Balance" label-for="invoice-balance">
          <b-form-input id="invoice-balance" v-model="form.invoiceBalance" trim disabled />
        </b-form-group>

        <!-- Payment Amount -->
        <b-form-group label="Payment Amount" label-for="payment-amount">
          <b-form-input
            id="payment-amount"
            v-model="form.paymentAmount"
            placeholder="$10000"
            trim
            type="number"
            name="paymentAmount"
          />
        </b-form-group>

        <!-- Payment Date -->
        <b-form-group label="Payment Date" label-for="payment-date">
          <flat-pickr v-model="form.paymentDate" name="paymentAmount" class="form-control" />
        </b-form-group>

        <b-form-group label="Payment Method" label-for="payment-method">
          <v-select
            v-model="form.paymentMethod"
            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
            :options="paymentMethods"
            label="Payment Method"
            placeholder="Select Payment Method"
            input-id="payment-method"
            :clearable="false"
          />
        </b-form-group>

        <!-- Internal Payment Note -->
        <b-form-group label="Internal Payment Note" label-for="internal-payment-note">
          <b-form-textarea
            id="internal-payment-note"
            v-model="form.internalPaymentNote"
            placeholder="Internal Payment Note"
            rows="5"
            trim
            name="internalPaymentNote"
          />
        </b-form-group>

        <!-- Form Actions -->
        <div class="d-flex mt-2">
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            class="mr-2"
            type="submit"
            @click="hide(); addInvoiceLog ();"
          >Send</b-button>
          <b-button
            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
            variant="outline-secondary"
            @click="hide"
          >Cancel</b-button>
        </div>
      </b-form>
    </template>
  </b-sidebar>
</template>

<script>
import {
  BSidebar,
  BForm,
  BFormGroup,
  BFormInput,
  BFormTextarea,
  BButton,
} from "bootstrap-vue";

import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import Ripple from "vue-ripple-directive";
import flatPickr from "vue-flatpickr-component";
import vSelect from "vue-select";
import axiosIns from "@/libs/axios";
const paymentMethods = [
  "Cash",
  "Mobile Banking",
  "Bank Transfer",
  "Debit",
  "Credit",
  "Paypal",
];

export default {
  components: {
    BSidebar,
    BForm,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BButton,
    flatPickr,
    vSelect,
  },
  directives: {
    Ripple,
  },

  data() {
    return {
      paymentMethods,
      form: {
        sale_id: this.$route.params.id,
        invoiceBalance: 1000,
        paymentDate: "",
        paymentMethod: "",
        internalPaymentNote: "",
        paymentAmount: "",
      },
    };
  },

  created() {
    this.addInvoiceLog();
  },
  watch: {
    $route() {
      this.addInvoiceLog();
    },
  },
  methods: {
    addInvoiceLog() {
      axiosIns.post("api/v1/shop/invoice-log", this.form).then((response) => {
        this.$router.go(this.$router.currentRoute);
        this.$toast({
          component: ToastificationContent,
          props: {
            title: "Amount Added",
            icon: "EditIcon",
            variant: "success",
          },
        });
      });
    },
  },
};
</script>

<style lang="scss">
@import "@core/scss/vue/libs/vue-select.scss";
@import "@core/scss/vue/libs/vue-flatpicker.scss";
</style>
