<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="card-header">
          <span class="card-title">Sale Information</span>
        </div>
        <div class="card-body">
          <validation-observer ref="createsale">
            <b-form>
              <b-row>
                <b-col md="6">
                  <b-form-group label="Name">
                    <validation-provider #default="{ errors }" name="item_name" rules="required">
                       <select
                      v-model="form.client_id"
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
                        v-for="cName in clientsNames"
                        :key="cName.id"
                        :value="cName.id"
                      >
                        {{ cName.name }}
                      </option>
                    </select>
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Address">
                    <validation-provider #default="{ errors }" name="address" rules="required">
                      <b-form-textarea
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
                  <b-form-group label="Product">
                    <validation-provider #default="{ errors }" name="product" rules="required">
                   <select
                      v-model="form.product_id"
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
                        v-for="product in products"
                        :key="product.id"
                        :value="product.id"
                      >
                        {{ product.name }}
                      </option>
                    </select>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="SKU">
                    <validation-provider #default="{ errors }" name="sku" rules="required">
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
                  <b-form-group label="Total Amount">
                    <validation-provider #default="{ errors }" name="amount" rules="required">
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
                  <b-form-group label="Advance Payment">
                    <validation-provider
                      #default="{ errors }"
                      name="advance_payment"
                      rules="required"
                    >
                      <b-form-input
                        v-model="form.advance_payment"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Advance payment"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Notes">
                    <validation-provider #default="{ errors }" name="notes" rules="required">
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
                  <b-form-group label="Due Payment">
                    <validation-provider #default="{ errors }" name="due_payment" rules="required">
                      <b-form-input
                        v-model="form.due_payment"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Due payment"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Websites">
                    <validation-provider #default="{ errors }" name="websites" rules="required">
                      <b-form-input
                        v-model="form.websites"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Websites"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group label="Next Payment">
                    <validation-provider #default="{ errors }" name="next_payment" rules="required">
                      <b-form-input
                        v-model="form.next_payment"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Next Payment"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <label for="example-datepicker">Next Payment date</label>
                  <b-form-datepicker
                    id="example-datepicker"
                    v-model="form.next_payment_date"
                    class="mb-1"
                  />
                </b-col>
                <b-col md="6">
                  <label for="example-datepicker">Start date</label>
                  <b-form-datepicker
                    id="example-datepicker2"
                    v-model="form.start_date"
                    class="mb-1"
                  />
                </b-col>
                <b-col md="6">
                  <label for="example-datepicker">End date</label>
                  <b-form-datepicker id="example-datepicker3" v-model="form.end_date" class="mb-1" />
                </b-col>
                <b-col cols="12">
                  <b-button variant="primary" type="submit" @click.prevent="validationForm">Submit</b-button>
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
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
  BFormInput,
  BFormGroup,
  BForm,
  BRow,
  BCol,
  BButton,
  BFormDatepicker
} from "bootstrap-vue";
import { required } from "@validations";
import axiosIns from "@/libs/axios";

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
    BFormDatepicker
  },
  data() {
    return {
      form: {
        product_id: "",
        client_id: "",
        sku: "",
        address: "",
        amount: "",
        advance_payment: "",
        notes: "",
        due_payment: "",
        websites: "",
        next_payment_date: "",
        next_payment: "",
        start_date: "",
        end_date: ""
      },
      customers: [],
      products: [],
      clientsNames: [],
      required
    };
  },
  mounted() {
    this.getProducts();
  },
  methods: {
    getProducts() {
      axiosIns.get(`api/v1/shop/sale`).then(response => {
        this.products = response.data.product;
        this.clientsNames = response.data.client;
      });
    },

    validationForm() {
      this.$refs.createsale
        .validate()
        .then(success => {
          if (success) {
            axiosIns.post("api/v1/shop/sale", this.form).then(response => {
              console.log(response.data);
              // first reset your form values
              for (const key in this.form) {
                this.form[key] = "";
              }
              // then do this to reset your ValidationObserver
              this.$nextTick(() => this.$refs.createsale.reset());
              if (response.data.success) {
                this.$bvToast.toast(response.data.message, {
                  title: "Success",
                  variant: "success",
                  solid: true
                });
              } else {
                this.$bvToast.toast(response.data.message, {
                  title: "Failed!",
                  variant: "danger",
                  solid: true
                });
              }
            });
          }
        })
        .catch(error => {
          this.$refs.createsale.setErrors(error.response.data.errors);
        });
    }
  }
};
</script>


