<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">
      <!-- Brand logo-->
      <b-link class="brand-logo">
        <img
          :src="appLogoImage"
          alt=""
          class=""
          width="100px"
        >
      </b-link>
      <!-- /Brand logo-->

      <!-- Left Text-->
      <b-col
        lg="8"
        class="d-none d-lg-flex align-items-center p-5"
      >
        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
          <b-img
            fluid
            :src="imgUrl"
            alt="Login V2"
          />
        </div>
      </b-col>
      <!-- /Left Text-->

      <!-- Login-->
      <b-col
        lg="4"
        class="d-flex align-items-center auth-bg px-2 p-lg-5"
      >
        <b-col
          sm="8"
          md="6"
          lg="12"
          class="px-xl-2 mx-auto"
        >
          <b-card-title
            title-tag="h2"
            class="font-weight-bold mb-1"
          >
            Welcome to Cash Baksho!
          </b-card-title>
          <b-card-text class="mb-2">
            Please verify your email address
          </b-card-text>

          <!-- form -->
          <validation-observer ref="loginValidation">
            <b-form
              class="auth-login-form mt-2"
              @submit.prevent
            >
              <!-- email -->
              <b-form-group
                label="Verification code"
                label-for="verification_code"
              >
                <validation-provider
                  #default="{ errors }"
                  name="verification_code"
                  rules="required"
                >
                  <b-form-input
                    id="verification_code"
                    v-model="verification_code"
                    :state="errors.length > 0 ? false:null"
                    name="verification_code"
                    placeholder="code"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- submit buttons -->
              <b-button
                type="submit"
                variant="primary"
                block
                @click="validationForm"
              >
                Submit
              </b-button>
            </b-form>
          </validation-observer>

          <b-card-text class="text-center mt-2">
            <span>Yet not get code? </span>
            <b-link to="" @click.prevent="resendCode">
              <span>Resend</span>
            </b-link>
          </b-card-text>
        </b-col>
      </b-col>
      <!-- /Login-->
    </b-row>
  </div>
</template>

<script>
/* eslint-disable global-require */
import { $themeConfig } from '@themeConfig'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BRow, BCol, BLink, BFormGroup, BFormInput, BCardText, BCardTitle, BImg, BForm, BButton,
} from 'bootstrap-vue'
import { required } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import store from '@/store/index'
import axiosIns from '@/libs/axios'
import useJwt from '@/auth/jwt/useJwt'

export default {
  components: {
    BRow,
    BCol,
    BLink,
    BFormGroup,
    BFormInput,
    BCardText,
    BCardTitle,
    BImg,
    BForm,
    BButton,
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      verification_code: '',
      sideImg: require('@/assets/images/pages/login-v2.svg'),
      // validation rulesimport store from '@/store/index'
      required,
    }
  },
  setup(props) {
    // App Name
    const { appName, appLogoImage } = $themeConfig.app

    return {
      appName,
      appLogoImage,
    }
  },
  computed: {
    imgUrl() {
      if (store.state.appConfig.layout.skin === 'dark') {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require('@/assets/images/pages/login-v2-dark.svg')
        return this.sideImg
      }
      return this.sideImg
    },
  },
  methods: {
    validationForm() {
      this.$refs.loginValidation.validate().then(success => {
        if (success) {
          axiosIns.post('api/v1/shop/verify', {
            email: this.$route.query.email ?? null,
            verification_code: this.verification_code,
          }).then(response => {
            // useJwt.setToken(response.data.access_token)
            // useJwt.setRefreshToken(response.data.refresh_token)
            console.log(response)
            if (response.data.success) {
              localStorage.setItem('userAccessToken', response.data.access_token)
              localStorage.setItem('userData', JSON.stringify(response.data.userData))
              this.$router.push({ name: 'user.homepage' })
            }
          }).catch(error => {
            console.log(error)
            // if (!error.response.data.success) {
            //   // this.errors = error.response.data.error
            //   this.$bvToast.toast(error.response.data.errors, {
            //     title: 'Failed',
            //     variant: 'danger',
            //     solid: true,
            //   })
            // }
            this.$refs.loginValidation.setErrors(error.response.data.errors)
            // this.errors = error.response.data.errors
          })
        }
      })
    },
    resendCode() {
      axiosIns.post('api/v1/shop/verify/resend', {
        email: this.$route.query.email,
      }).then(response => {
        this.$bvToast.toast(response.data.message, {
          title: 'Success',
          variant: 'success',
          solid: true,
        })
      })
    },
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
