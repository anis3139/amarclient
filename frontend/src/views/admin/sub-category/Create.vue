<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="card-header">
          <span class="card-title">Sub Category Information</span>
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
                  <b-form-group label="name">
                    <validation-provider
                      #default="{ errors }"
                      name="name"
                      rules="required"
                    >
                      <b-form-input
                        v-model="form.name"
                        :state="errors.length > 0 ? false:null"
                        placeholder="Category Name"
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
        name: '',
      },
      categories: [],
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
          axiosIns.post('api/v1/admin/sub-category', this.form).then(response => {
            console.log(response)
            // first reset your form values
            for (const key in this.form) {
              this.form[key] = ''
            }
            // then do this to reset your ValidationObserver
            this.$nextTick(() => this.$refs.createproduct.reset())
            this.$bvToast.toast('Sub Category created successfully.', {
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
      axiosIns.get('api/v1/admin/category').then(response => {
        this.categories = response.data
      }).catch(error => {
        console.log(error)
      })
    },
  },
}
</script>
