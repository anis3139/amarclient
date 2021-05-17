<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="card-header">
          <span class="card-title">product Information</span>
        </div>
        <div class="card-body">
          <validation-observer ref="createproduct">
            <b-form>
              <b-row>
                <b-col md="6">
                  <b-form-group label="name">
                    <validation-provider
                        #default="{ errors }"
                        name="Name"
                        rules="required"
                    >
                      <b-form-input
                          v-model="form.name"
                          :state="errors.length > 0 ? false:null"
                          placeholder="Full Name"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="SKU">
                    <validation-provider
                        #default="{ errors }"
                        name="SKU"
                    >
                      <b-form-input
                          v-model="form.sku"
                          :state="errors.length > 0 ? false:null"
                          type="text"
                          placeholder="sku"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Price">
                    <validation-provider
                        #default="{ errors }"
                        name="Price"
                    >
                      <b-form-input
                          v-model="form.price"
                          :state="errors.length > 0 ? false:null"
                          type="text"
                          placeholder="Price"
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
  BFormInput, BFormGroup, BForm, BRow, BCol, BButton,
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
  },
  data() {
    return {
      form: {
        name: '',
        sku: '',
        price: '',
      },
      required,
    }
  },
  created() {
    this.getproductInfo()
  },
  methods: {
    validationForm() {
      this.$refs.createproduct.validate().then(success => {
        if (success) {
          axiosIns.put(`api/v1/shop/product/${this.$route.params.id}`, this.form).then(response => {
            // console.log(response)
            this.$nextTick(() => this.$refs.createproduct.reset())
            this.$bvToast.toast(response.data.message, {
              title: 'Success',
              variant: 'success',
              solid: true,
            })
          })
        }
      })
    },
    getproductInfo() {
      axiosIns.get(`api/v1/shop/product/${this.$route.params.id}`).then(response => {
        this.form.name = response.data.product_info.name
        this.form.sku = response.data.product_info.sku
        this.form.price = response.data.product_info.price
      })
    },
  },
}
</script>
