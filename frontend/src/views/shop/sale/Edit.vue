<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="card-header">
          <span class="card-title">sale Information</span>
        </div>
        <div class="card-body">
          <validation-observer ref="createsale">
            <b-form>
              <b-row>
                <b-col md="6">
                  <b-form-group label="Customer name">
                    <select
                      v-model="form.customer_id"
                      class="form-control"
                      required
                    >
                      <option
                        value=""
                        selected
                      >
                        Choose one
                      </option>
                      <option
                        v-for="customer in customers"
                        :key="customer.id"
                        :value="customer.id"
                        :selected="customer.id == form.customer_id"
                      >
                        {{ customer.name }}
                      </option>
                    </select>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Product name">
                    <validation-provider
                        #default="{ errors }"
                        name="item_name"
                        rules="required"
                    >
                      <b-form-input
                          v-model="form.item_name"
                          :state="errors.length > 0 ? false:null"
                          type="text"
                          placeholder="Product name"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Amount">
                    <validation-provider
                      #default="{ errors }"
                      name="Amount"
                      rules="required"
                    >
                      <b-form-input
                        v-model="form.amount"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="amount"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <label for="example-datepicker">Choose a date</label>
                  <b-form-datepicker
                    id="example-datepicker"
                    v-model="form.date"
                    class="mb-1"
                  />
                </b-col>
                <b-col md="6">
                  <b-form-group label="Description">
                    <validation-provider
                      #default="{ errors }"
                      name="Description"
                    >
                      <b-form-textarea
                        v-model="form.description"
                        :state="errors.length > 0 ? false:null"
                        placeholder="Description"
                        rows="3"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col cols="12">
                  <b-button
                    variant="primary"
                    type="submit"
                    @click.prevent="validationForm"
                  >
                    Update
                  </b-button>
                </b-col>
              </b-row>
            </b-form>
          </validation-observer>
        </div>
      </div>
      <!-- form -->
    </b-col>
  </b-row>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BFormInput, BFormGroup, BForm, BRow, BCol, BButton, BFormDatepicker,
} from 'bootstrap-vue'
import { required } from '@validations'
import axiosIns from '@/libs/axios'

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
    BFormInput,
    BFormGroup,
    BForm,
    BRow,
    BCol,
    BButton,
    BFormDatepicker,
  },
  data() {
    return {
      form: {
        item_name: '',
        customer_id: '',
        amount: '',
        date: '',
        description: '',
      },
      customers: [],
      // products: [],
      required,
    }
  },
  created() {
    this.getsaleInfo()
    this.getCustomerData()
    // this.getProducts()
  },
  methods: {
    getCustomerData() {
      axiosIns.get('api/v1/shop/customer').then(response => {
        // console.log(response.data)
        this.customers = response.data
      })
    },
    getProducts() {
      axiosIns.get('api/v1/shop/product').then(response => {
        // console.log(response.data)
        this.products = response.data
      })
    },
    validationForm() {
      this.$refs.createsale.validate().then(success => {
        if (success) {
          axiosIns.put(`api/v1/shop/sale/${this.$route.params.id}`, this.form).then(response => {
            // console.log(response)
            this.$nextTick(() => this.$refs.createsale.reset())
            this.$bvToast.toast(response.data.message, {
              title: 'Success',
              variant: 'success',
              solid: true,
            })
          })
        }
      })
    },
    getsaleInfo() {
      axiosIns.get(`api/v1/shop/sale/${this.$route.params.id}`).then(response => {
        console.log(response.data)
        this.form.item_name = response.data.sale_info.item_name
        this.form.customer_id = response.data.sale_info.customer_id
        this.form.amount = response.data.sale_info.amount
        this.form.date = response.data.sale_info.date
        this.form.description = response.data.sale_info.description
        // console.log(this.form)
      })
    },
  },
}
</script>
