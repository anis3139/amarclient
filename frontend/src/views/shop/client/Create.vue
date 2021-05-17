<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="card-header">
          <span class="card-title">Client Information</span>
        </div>
        <div class="card-body">
          <validation-observer ref="createCustomer">
            <b-form>
              <b-row>
                <b-col md="6">
                  <b-form-group label="Name">
                    <validation-provider
                      #default="{ errors }"
                      name="name"
                      rules="required"
                    >
                      <b-form-input
                        v-model="form.name"
                        :state="errors.length > 0 ? false:null"
                        placeholder="Name"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Company">
                    <validation-provider
                      #default="{ errors }"
                      name="company"
                      rules="required"
                    >
                      <b-form-input
                        v-model="form.company"
                        :state="errors.length > 0 ? false:null"
                        placeholder="Company"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Mobile 1">
                    <validation-provider
                      #default="{ errors }"
                      name="phone_number_1"
                    >
                      <b-form-input
                        v-model="form.phone_number_1"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Mobile 1"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Mobile 2">
                    <validation-provider
                      #default="{ errors }"
                      name="phone_number_2"
                    >
                      <b-form-input
                        v-model="form.phone_number_2"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Mobile 2"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Email">
                    <validation-provider
                      #default="{ errors }"
                      name="email"
                    >
                      <b-form-input
                        v-model="form.email"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Email"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Notes">
                    <validation-provider
                      #default="{ errors }"
                      name="notes"
                    >
                      <b-form-input
                        v-model="form.notes"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Notes"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Address">
                    <validation-provider
                      #default="{ errors }"
                      name="address"
                    >
                      <b-form-input
                        v-model="form.address"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Address"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Website">
                    <validation-provider
                      #default="{ errors }"
                      name="website"
                    >
                      <b-form-input
                        v-model="form.website"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Website"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Country">
                    <select
                      v-model="form.country_id"
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
                        v-for="country in countries"
                        :key="country.id"
                        :value="country.id"
                      >
                        {{ country.name }}
                      </option>
                    </select>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Division">
                    <select
                      v-model="form.division_id"
                      class="form-control"
                      required
                      @change="getDistricts(form.division_id)"
                    >
                      <option
                        value=""
                        selected
                      >
                        Choose one
                      </option>
                      <option
                        v-for="division in divisions"
                        :key="division.id"
                        :value="division.id"
                      >
                        {{ division.name }}
                      </option>
                    </select>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="District">
                    <select
                      v-model="form.district_id"
                      class="form-control"
                      required
                      @change="getUpazilas(form.district_id)"
                    >
                      <option
                        value=""
                        selected
                      >
                        Choose one
                      </option>
                      <option
                        v-for="district in districts"
                        :key="district.id"
                        :value="district.id"
                      >
                        {{ district.name }}
                      </option>
                    </select>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Upazila">
                    <select
                      v-model="form.upazila_id"
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
                        v-for="upazila in upazilas"
                        :key="upazila.id"
                        :value="upazila.id"
                      >
                        {{ upazila.name }}
                      </option>
                    </select>
                  </b-form-group>
                </b-col>
                <b-col cols="12">
                  <b-button
                    variant="primary"
                    type="submit"
                    @click.prevent="validationForm"
                  >
                    Submit
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
        company: '',
        phone_number_1: '',
        phone_number_2: '',
        email: '',
        notes: '',
        address: '',
        website: '',
        country_id: '',
        division_id: '',
        district_id: '',
        upazila_id: '',
      },
      countries: [],
      divisions: [],
      districts: [],
      upazilas: [],
      required,
    }
  },
  created() {
    this.getAllCountries()
    this.getAllDivisions()
  },
  methods: {
    validationForm() {
      this.$refs.createCustomer.validate().then(success => {
        if (success) {
          axiosIns.post('api/v1/shop/client', this.form).then(response => {
            console.log(response)
            // first reset your form values
            // eslint-disable-next-line guard-for-in,no-restricted-syntax
            for (const key in this.form) {
              this.form[key] = ''
            }
            // then do this to reset your ValidationObserver
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
    getAllCountries() {
      axiosIns.get('api/v1/get-countries').then(response => {
        this.countries = response.data
      }).catch(error => {
        console.log(error)
      })
    },
    getAllDivisions() {
      axiosIns.get('api/v1/get-divisions').then(response => {
        this.divisions = response.data
      }).catch(error => {
        console.log(error)
      })
    },
    getDistricts(divisionId) {
      axiosIns.get(`api/v1/get-districts/${divisionId}`).then(response => {
        this.districts = response.data
        // console.log(response)
      }).catch(error => {
        console.log(error)
      })
    },
    getUpazilas(districtId) {
      axiosIns.get(`api/v1/get-upazilas/${districtId}`).then(response => {
        console.log(response.data)
        this.upazilas = response.data
      }).catch(error => {
        console.log(error)
      })
    },
  },
}
</script>
