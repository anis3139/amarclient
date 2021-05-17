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
                      {{ data.total_shops }}
                    </h4>
                    <b-card-text class="font-small-3 mb-0">
                      Shops
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
                      {{ data.total_customers }}
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
                      {{ data.total_suppliers }}
                    </h4>
                    <b-card-text class="font-small-3 mb-0">
                      Suppliers
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
      data: '',
      transactions: [],
    }
  },
  mounted() {
    this.getStatistic()
  },
  methods: {
    getStatistic() {
      axiosIns.get('api/v1/admin/report').then(response => {
        // console.log(response.data)
        this.data = response.data.data
      })
    },
  },
}
</script>

<style>

</style>
