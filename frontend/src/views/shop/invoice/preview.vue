<template>
  <section class="invoice-preview-wrapper">
    <b-row v-if="invoiceData" class="invoice-preview">
      <!-- Col: Left (Invoice Container) -->
      <b-col cols="12" xl="9" md="8">
        <b-card no-body class="invoice-preview-card">
          <!-- Header -->
          <b-card-body class="invoice-padding pb-0">
            <div
              class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0"
            >
              <!-- Header: Left Content -->
              <div>
                <div class="logo-wrapper">
                  <h3 class="text-primary invoice-logo">Amar Client</h3>
                </div>
                <p class="card-text mb-25">Office 149, 450 South Brand Brooklyn</p>
                <p class="card-text mb-25">San Diego County, CA 91905, USA</p>
                <p class="card-text mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p>
              </div>

              <!-- Header: Right Content -->
              <div class="mt-md-0 mt-2">
                <h4 class="invoice-title">
                  Invoice
                  <span class="invoice-number">#{{ invoiceData.id }}</span>
                </h4>
                <div class="invoice-date-wrapper">
                  <p class="invoice-date-title">Date Issued:</p>
                  <p class="invoice-date">{{moment(invoiceData.start_date).format('Do MMMM, YYYY')}}</p>
                </div>
                <div class="invoice-date-wrapper">
                  <p class="invoice-date-title">Next Payment Date:</p>
                  <p
                    class="invoice-date"
                  >{{moment(invoiceData.next_payment_date ).format('Do MMMM, YYYY')}}</p>
                </div>
              </div>
            </div>
          </b-card-body>

          <!-- Spacer -->
          <hr class="invoice-spacing" />

          <!-- Invoice Client & Payment Details -->
          <b-card-body class="invoice-padding pt-0">
            <b-row class="invoice-spacing">
              <!-- Col: Invoice To -->
              <b-col cols="12" xl="6" class="p-0">
                <h6 class="mb-2">Invoice To:</h6>
                <h6 class="mb-25">{{ invoiceData.product[0].name }}</h6>
                <p>{{ invoiceData.address }}</p>
              </b-col>

              <!-- Col: Payment Details -->
              <b-col xl="6" cols="12" class="p-0 mt-xl-0 mt-2 d-flex justify-content-xl-end">
                <div>
                  <h6 class="mb-2">Payment Details:</h6>
                  <table>
                    <tbody>
                      <tr>
                        <td class="pr-1">Total Due:</td>
                        <td>
                          <span class="font-weight-bold">
                            &#2547; {{
                            invoiceData.due_payment
                            }}
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td class="pr-1">Next Payment:</td>
                        <td>
                          <span class="font-weight-bold">&#2547; {{ invoiceData.next_payment}}</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </b-col>
            </b-row>
          </b-card-body>

          <!-- Invoice Description: Table -->
          <b-table-lite
            responsive
            :items="invoiceDescription"
            :fields="['name', 'sku']"
          >
            <template #cell(name)="data">
              <b-card-text class="font-weight-bold mb-25">
               {{
                data.item.name
                }}
              </b-card-text>
              
            </template>
          </b-table-lite>

          <!-- Col: Total -->
          <b-container class="bv-example-row" v-if="invoiceLogs.length>0">
            <b-row>
              <b-col cols="12" md="12" class="p-5">
                <b-table
                  striped
                  hover
                  :items="invoiceLogs"
                  :fields="fields"

                >
                  <template
                    v-slot:cell(payment_date)="row"  class="my-cell-overflow-y"
                  >{{ moment(row.item.payment_date ).format('Do MMMM, YYYY') }}</template>
                  <template
                    v-slot:cell(payment_amount)="row"
                  >&#2547; {{row.item.payment_amount.toFixed(2) }}</template>
                </b-table>

                <h2
                  class="m-3 text-center"
                >Total Installment Value: &#2547; {{installment.toFixed(2)}}</h2>
              </b-col>
            </b-row>
          </b-container>

          <!-- Col: Total -->

          <!-- Invoice Description: Total -->
          <b-card-body class="invoice-padding pb-0">
            <b-row>
              <!-- Col: Sales Persion -->
              <b-col cols="12" md="6" class="mt-md-0 mt-3">
                <b-card-text class="my-3">
                  <span class="font-weight-bold">Thanks for purchasing with us</span>
                </b-card-text>
              </b-col>

              <!-- Col: Total -->
              <b-col cols="12" md="6" class="mt-md-6 d-flex justify-content-center">
                <div class="invoice-total-wrapper">
                  <div class="invoice-total-item">
                    <p class="invoice-total-title">Total Amount:</p>
                    <p class="invoice-total-amount">&#2547; {{ amount.toFixed(2) }}</p>
                  </div>
                  <div class="invoice-total-item">
                    <p class="invoice-total-title">Advance Payment:</p>
                    <p class="invoice-total-amount">&#2547; {{ advance_payment.toFixed(2) }}</p>
                  </div>
                  <div class="invoice-total-item">
                    <p class="invoice-total-title">Total Installment:</p>
                    <p class="invoice-total-amount">&#2547; {{installment.toFixed(2)}}</p>
                  </div>

                  <hr class="my-50" />
                  <div class="invoice-total-item">
                    <p class="invoice-total-title">Due Amount:</p>
                    <p class="invoice-total-amount">&#2547; {{ dueAmount.toFixed(2) }}</p>
                  </div>
                </div>
              </b-col>
            </b-row>
          </b-card-body>

          <!-- Spacer -->
          <hr class="invoice-spacing" />

          <!-- Note -->
        </b-card>
      </b-col>

      <!-- Right Col: Card -->
      <b-col cols="12" md="4" xl="3" class="invoice-actions">
        <b-card>
          <!-- Button: Send Invoice -->

          <!-- Button: Print -->
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            v-b-toggle.sidebar-send-invoice
            variant="primary"
            class="mb-75"
            block
            @click="printInvoice"
          >Print</b-button>

          <!-- Button: Edit -->
          <b-button
            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
            variant="outline-secondary"
            class="mb-75"
            block
            :to="{ name: 'apps-invoice-edit', params: { id: $route.params.id } }"
          >Edit</b-button>

          <!-- Button: Add Payment -->
          <b-button
            v-b-toggle.sidebar-invoice-add-payment
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="success"
            class="mb-75"
            block
          >Add Payment</b-button>
        </b-card>
      </b-col>
    </b-row>
    <invoice-sidebar-add-payment />
  </section>
</template>

<script>
import {
  BRow,
  BCol,
  BCard,
  BCardBody,
  BTableLite,
  BCardText,
  BButton,
  BAlert,
  BLink,
  VBToggle,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import InvoiceSidebarAddPayment from "./InvoiceSidebarAddPayment.vue";
import axiosIns from "@/libs/axios";
export default {
  directives: {
    Ripple,
    "b-toggle": VBToggle,
  },
  components: {
    BRow,
    BCol,
    BCard,
    BCardBody,
    BTableLite,
    BCardText,
    BButton,
    BAlert,
    BLink,
    InvoiceSidebarAddPayment,
  },
  data() {
    return {
      fields: ["payment_date", "payment_method", "note", "payment_amount"],
      advance_payment: "",
      amount: "",
      next_payment: "",
      due_payment: "",
      invoiceData: [],
      invoiceLogs: [],
      totalInstallment: "",
      invoiceDescription: [],
    };
  },
  computed: {
    installment() {
      let value = this.invoiceLogs;
      var sum = 0;
      value.forEach((number, index) => {
        sum += number.payment_amount;
      });
      this.totalInstallment = sum;
      return sum;
    },
    dueAmount() {
      var due = this.amount - this.advance_payment;
      if (this.totalInstallment > 0) {
        var finalDue = due - this.totalInstallment;
      } else {
        finalDue = due;
      }
      return finalDue;
    },
  },
  mounted() {
    this.getSaleData();
  },

  methods: {
    getSaleData() {
      axiosIns
        .get(`api/v1/shop/sale/${this.$route.params.id}`)
        .then((response) => {
          this.invoiceData = response.data.sale_info;
          this.due_payment = response.data.sale_info.due_payment;
          this.advance_payment = response.data.sale_info.advance_payment;
          this.next_payment = response.data.sale_info.next_payment;
          this.amount = response.data.sale_info.amount;
          this.invoiceLogs = response.data.sale_info.invoice_log;
          this.invoiceDescription = response.data.sale_info.product;
          console.log(response.data.sale_info.product[0].name);
        });
    },
  },
  setup() {
    const printInvoice = () => {
      window.print();
    };

    return {
      printInvoice,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "~@core/scss/base/pages/app-invoice.scss";
</style>

<style lang="scss">
@media print {
  // Global Styles
  body {
    background-color: transparent !important;
  }

  nav.header-navbar {
    display: none;
  }
  .main-menu {
    display: none;
  }
  .header-navbar-shadow {
    display: none !important;
  }
  .content.app-content {
    margin-left: 0;
    padding-top: 2rem !important;
  }
  footer.footer {
    display: none;
  }
  .card {
    background-color: transparent;
    box-shadow: none;
  }
  .customizer-toggle {
    display: none !important;
  }

  // Invoice Specific Styles
  .invoice-preview-wrapper {
    .row.invoice-preview {
      .col-md-8 {
        max-width: 100%;
        flex-grow: 1;
      }

      .invoice-preview-card {
        .card-body:nth-of-type(2) {
          .row {
            > .col-12 {
              max-width: 50% !important;
            }

            .col-12:nth-child(2) {
              display: flex;
              align-items: flex-start;
              justify-content: flex-end;
              margin-top: 0 !important;
            }
          }
        }
      }
    }

    // Action Right Col
    .invoice-actions {
      display: none;
    }
  }
}

.invoice-preview .invoice-total-wrapper,
.invoice-edit .invoice-total-wrapper,
.invoice-add .invoice-total-wrapper {
  max-width: 16rem !important;
}
.my-cell-overflow-y{
  max-height: 2rem;
  overflow-y: auto !important;
}
</style>
