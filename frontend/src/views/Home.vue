<template>
  <section id="dashboard-ecommerce">
    <b-row class="match-height">
      <b-col
        xl="12"
        md="12"
      >
        <b-card
          no-body
          class="card-statistics"
        >
          <b-card-header>
            <b-card-title>Statistics</b-card-title>
          </b-card-header>
          <b-card-body class="statistics-body">
            <b-row>
              <b-col
                xl="2"
                sm="6"
                class=""
              >
                <b-media no-body>
                  <b-media-body class="my-auto">
                    <h4 class="font-weight-bolder mb-0">
                      {{ statistic.total_sales }}
                    </h4>
                    <b-card-text class="font-small-3 mb-0">
                      Sales
                    </b-card-text>
                  </b-media-body>
                </b-media>
              </b-col>
              <b-col
                xl="3"
                sm="6"
                class=""
              >
                <b-media no-body>
                  <b-media-body class="my-auto">
                    <h4 class="font-weight-bolder mb-0">
                      {{ statistic.total_purchases }}
                    </h4>
                    <b-card-text class="font-small-3 mb-0">
                      Purchases
                    </b-card-text>
                  </b-media-body>
                </b-media>
              </b-col>
              <b-col
                xl="2"
                sm="6"
                class=""
              >
                <b-media no-body>
                  <b-media-body class="my-auto">
                    <h4 class="font-weight-bolder mb-0">
                      {{ statistic.total_customers }}
                    </h4>
                    <b-card-text class="font-small-3 mb-0">
                      Customers
                    </b-card-text>
                  </b-media-body>
                </b-media>
              </b-col>
              <b-col
                xl="2"
                sm="6"
                class=""
              >
                <b-media no-body>
                  <b-media-body class="my-auto">
                    <h4 class="font-weight-bolder mb-0">
                      {{ statistic.total_suppliers }}
                    </h4>
                    <b-card-text class="font-small-3 mb-0">
                      Suppliers
                    </b-card-text>
                  </b-media-body>
                </b-media>
              </b-col>
              <b-col
                xl="2"
                sm="6"
                class=""
              >
                <b-media no-body>
                  <b-media-body class="my-auto">
                    <h4 class="font-weight-bolder mb-0">
                      {{ statistic.total_products }}
                    </h4>
                    <b-card-text class="font-small-3 mb-0">
                      Products
                    </b-card-text>
                  </b-media-body>
                </b-media>
              </b-col>
            </b-row>
          </b-card-body>
        </b-card>
      </b-col>
      <b-col
        lg="4"
        md="6"
      >
        <b-card
          v-if="transactions.length > 0"
          class="card-transaction"
          no-body
        >
          <b-card-header>
            <b-card-title>Transactions</b-card-title>

            <b-dropdown
              variant="link"
              no-caret
              class="chart-dropdown"
              toggle-class="p-0"
              right
            >
              <template #button-content>
                <feather-icon
                  icon="MoreVerticalIcon"
                  size="18"
                  class="text-body cursor-pointer"
                />
              </template>
              <!--              <b-dropdown-item href="#">-->
              <!--                Last 28 Days-->
              <!--              </b-dropdown-item>-->
              <!--              <b-dropdown-item href="#">-->
              <!--                Last Month-->
              <!--              </b-dropdown-item>-->
              <!--              <b-dropdown-item href="#">-->
              <!--                Last Year-->
              <!--              </b-dropdown-item>-->
            </b-dropdown>
          </b-card-header>

          <b-card-body>
            <div
              v-for="transaction in transactions"
              :key="transaction.id"
              class="transaction-item"
            >
              <b-media no-body>
                <b-media-body>
                  <h6 class="transaction-title">
                    {{ transaction.transactionable.name }}
                  </h6>
                  <small>{{ transaction.user_type }}</small>
                </b-media-body>
              </b-media>
              <div
                class="font-weight-bolder"
                :class="transaction.given ? 'text-danger':'text-success'"
              >
                {{ transaction.given ? '-' : '+' }}{{ transaction.given ? transaction.given : transaction.taken }}
              </div>
            </div>
          </b-card-body>
        </b-card>
      </b-col>
    </b-row>
  </section>
</template>

<script>
import { BCard, BCardText } from 'bootstrap-vue'
import axiosIns from '@/libs/axios'

export default {
  components: {
    BCard,
    BCardText,
  },
  data() {
    return {
      statistic: '',
      transactions: [],
    }
  },
  mounted() {
    // this.getStatistic()
    // this.getTransactionReport()
  },
  methods: {
    getStatistic() {
      axiosIns.get('api/v1/shop/report').then(response => {
        // console.log(response.data)
        this.statistic = response.data.data
      })
    },
    getTransactionReport() {
      axiosIns.get('api/v1/shop/report/transaction').then(response => {
        // console.log(response.data.transactions)
        this.transactions = response.data.transactions
      })
    },
  },
}
</script>

<style>

</style>
