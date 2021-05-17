<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="card-header">
          <span class="card-title">Expense Information</span>
        </div>
        <div class="card-body">
          <validation-observer ref="createproduct">
            <b-form>
              <b-row>
                <b-col md="6">
                  <b-form-group label="Category">
                    <select
                        v-model="form.category_id"
                        class="form-control"
                        required
                        @change="getSubCategories(form.category_id)"
                    >
                      <option
                          value=""
                          selected
                      >
                        Choose one
                      </option>
                      <option
                          v-for="category in categories"
                          :key="category.id"
                          :value="category.id"
                      >
                        {{ category.name }}
                      </option>
                    </select>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Sub Category">
                    <select
                        v-model="form.sub_category_id"
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
                          v-for="sub_category in sub_categories"
                          :key="sub_category.id"
                          :value="sub_category.id"
                      >
                        {{ sub_category.name }}
                      </option>
                    </select>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Amount">
                    <validation-provider
                      #default="{ errors }"
                      name="amount"
                      rules="required"
                    >
                      <b-form-input
                        v-model="form.amount"
                        :state="errors.length > 0 ? false:null"
                        placeholder="Amount"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="notes">
                      <b-form-input
                        v-model="form.notes"
                        placeholder="Notes"
                      />
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
        category_id: '',
        sub_category_id: '',
        amount: '',
        notes: '',
      },
      categories: [],
      sub_categories: [],
      required,
    }
  },
  created() {
    this.getCategories()
  },
  methods: {
    validationForm() {
      this.$refs.createproduct.validate().then(success => {
        if (success) {
          axiosIns.post('api/v1/shop/expense', this.form).then(response => {
            // console.log(response)
            // first reset your form values
            for (let key in this.form ) {
              this.form[key] = ''
            }
            // then do this to reset your ValidationObserver
            this.$nextTick(() => this.$refs.createproduct.reset())
            this.$bvToast.toast('Expense created successfully.', {
              title: 'Success',
              variant: 'success',
              solid: true,
            })
          }).catch(error => {
            this.$refs.createproduct.setErrors(error.response.data.errors)
          })
        }
      })
    },
    getCategories() {
      axiosIns.get('api/v1/shop/get-categories').then(response => {
        this.categories = response.data
      }).catch(error => {
        console.log(error)
      })
    },
    getSubCategories(categoryId) {
      axiosIns.get(`api/v1/shop/get-sub-categories/${categoryId}`).then(response => {
        this.sub_categories = response.data
        // console.log(response)
      }).catch(error => {
        console.log(error)
      })
    },
  },
}
</script>
