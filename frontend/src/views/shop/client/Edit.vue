<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="card-header">
          <span class="card-title">Customer Information</span>
        </div>
        <div class="card-body">
          <validation-observer ref="createCustomer">
            <b-form>
              <b-row>
                <b-col md="6">
                  <b-form-group label="Customer name">
                    <validation-provider
                      #default="{ errors }"
                      name="name"
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
                  <b-form-group label="Phone number">
                    <validation-provider
                      #default="{ errors }"
                      name="phone_number"
                    >
                      <b-form-input
                        v-model="form.phone_number"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Phone number"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Description">
                    <validation-provider
                      #default="{ errors }"
                      name="description"
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
        phone_number: '',
        description: '',
      },
      required,
    }
  },
  created() {
    this.getCustomerInfo()
  },
  methods: {
    validationForm() {
      this.$refs.createCustomer.validate().then(success => {
        if (success) {
          axiosIns.put(`api/v1/shop/customer/${this.$route.params.id}`, this.form).then(response => {
            // console.log(response)
            this.$nextTick(() => this.$refs.createCustomer.reset())
            this.$bvToast.toast(response.data.message, {
              title: 'Success',
              variant: 'success',
              solid: true,
            })
          }).catch(error => {
            this.$refs.createCustomer.setErrors(error.response.data.errors)
          })
        }
      })
    },
    getCustomerInfo() {
      axiosIns.get(`api/v1/shop/customer/${this.$route.params.id}`).then(response => {
        if (!response.data.success){
          this.$bvToast.toast(response.data.message, {
            title: 'Failed',
            variant: 'warning',
            solid: true,
          })
          this.$router.push({ name: 'shop.customer' })
        }
        this.form.name = response.data.customer_info.name
        this.form.phone_number = response.data.customer_info.phone_number
        this.form.description = response.data.customer_info.description
      })
    },
  },
}
</script>
