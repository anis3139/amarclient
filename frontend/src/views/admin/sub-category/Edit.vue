<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="card-header">
          <span class="card-title">Category Information</span>
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
        category_id: '',
        name: '',
      },
      categories: [],
      required,
    }
  },
  created() {
    this.getCategoryInfo()
  },
  methods: {
    validationForm() {
      this.$refs.createproduct.validate().then(success => {
        if (success) {
          axiosIns.put(`api/v1/admin/category/${this.$route.params.id}`, this.form).then(response => {
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
    getCategoryInfo() {
      axiosIns.get(`api/v1/admin/category/${this.$route.params.id}`).then(response => {
        this.form.name = response.data.category_info.name
      })
    },
  },
}
</script>
