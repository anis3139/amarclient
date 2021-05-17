<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="card-header">
          <span class="card-title">product Information</span>
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            :to="{ name:'shop.product.create' }"
          >
            Add New
          </b-button>
        </div>
        <div class="card-body">
          <!-- search input -->
          <div class="custom-search d-flex justify-content-end">
            <b-form-group>
              <div class="d-flex align-items-center">
                <label class="mr-1">Search</label>
                <b-form-input
                  v-model="searchTerm"
                  placeholder="Search"
                  type="text"
                  class="d-inline-block"
                />
              </div>
            </b-form-group>
          </div>
          <!-- table -->
          <vue-good-table
            ref="productTable"
            :columns="columns"
            :rows="rows"
            :search-options="{
              enabled: true,
              externalQuery: searchTerm }"
            :pagination-options="{
              enabled: true,
              perPage:pageLength
            }"
            :line-numbers="true"
          >
            <template
              slot="table-row"
              slot-scope="props"
            >
              <!-- Column: Name -->
              <span
                v-if="props.column.field === 'Name'"
                class="text-nowrap"
              >
                <b-avatar
                  :src="props.row.avatar"
                  class="mx-1"
                />
                <span class="text-nowrap">{{ props.row.name }}</span>
              </span>

              <!-- Column: Action -->
              <span v-else-if="props.column.field === 'action'">
                <span>
                  <b-dropdown
                    variant="link"
                    toggle-class="text-decoration-none"
                    no-caret
                  >
                    <template v-slot:button-content>
                      <feather-icon
                        icon="MoreVerticalIcon"
                        size="16"
                        class="text-body align-middle mr-25"
                      />
                    </template>
                    <b-dropdown-item>
                      <feather-icon
                        icon="Edit2Icon"
                        class="mr-50"
                      />
                      <span><router-link :to="{name:'shop.product.edit',params:{id:props.row.id}}">Edit</router-link></span>
                    </b-dropdown-item>
                    <b-dropdown-item>
                      <feather-icon
                        icon="TrashIcon"
                        class="mr-50"
                      />
                      <span><a
                        href=""
                        @click.prevent="DeleteData(props.row.id)"
                      >Delete</a></span>
                    </b-dropdown-item>
                  </b-dropdown>
                </span>
              </span>

              <!-- Column: Common -->
              <span v-else>
                {{ props.formattedRow[props.column.field] }}
              </span>
            </template>

            <!-- pagination -->
            <template
              slot="pagination-bottom"
              slot-scope="props"
            >
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-center mb-0 mt-1">
                  <span class="text-nowrap ">
                    Showing 1 to
                  </span>
                  <b-form-select
                    v-model="pageLength"
                    :options="['3','5','10']"
                    class="mx-1"
                    @input="(value)=>props.perPageChanged({currentPerPage:value})"
                  />
                  <span class="text-nowrap"> of {{ props.total }} entries </span>
                </div>
                <div>
                  <b-pagination
                    :value="1"
                    :total-rows="props.total"
                    :per-page="pageLength"
                    first-number
                    last-number
                    align="right"
                    prev-class="prev-item"
                    next-class="next-item"
                    class="mt-1 mb-0"
                    @input="(value)=>props.pageChanged({currentPage:value})"
                  >
                    <template #prev-text>
                      <feather-icon
                        icon="ChevronLeftIcon"
                        size="18"
                      />
                    </template>
                    <template #next-text>
                      <feather-icon
                        icon="ChevronRightIcon"
                        size="18"
                      />
                    </template>
                  </b-pagination>
                </div>
              </div>
            </template>
          </vue-good-table>
        </div>
      </div>
    </b-col>
  </b-row>
</template>

<script>
import Ripple from 'vue-ripple-directive'
import { VueGoodTable } from 'vue-good-table'
import '@core/scss/vue/libs/vue-good-table.scss'
import axiosIns from '@/libs/axios'

export default {
  name: 'Index',
  components: {
    VueGoodTable,
  },

  directives: {
    Ripple,
  },
  data() {
    return {
      pageLength: 10,
      dir: false,
      columns: [
        {
          label: 'Name',
          field: 'name',
        },
        {
          label: 'SKU',
          field: 'sku',
        },
        {
          label: 'Price',
          field: 'price',
        },
        {
          label: 'Action',
          field: 'action',
        },
      ],
      rows: [],
      searchTerm: '',
    }
  },
  computed: {},
  created() {
    this.getproductData()
  },
  methods: {
    DeleteData(id) {
      this.$bvModal
        .msgBoxConfirm('Please confirm that you want to delete everything.', {
          title: 'Please Confirm',
          size: 'sm',
          okVariant: 'primary',
          okTitle: 'Yes',
          cancelTitle: 'No',
          cancelVariant: 'outline-secondary',
          hideHeaderClose: false,
          centered: true,
        })
        .then(value => {
          if (value) {
            axiosIns.delete(`api/v1/shop/product/${id}`).then(response => {
              // console.log(response.data)

              this.$bvToast.toast(response.data.message, {
                title: 'Success',
                variant: 'success',
                solid: true,
              })
              this.getproductData()
            })
          }
        })
    },
    getproductData() {
      axiosIns.get('api/v1/shop/product').then(response => {
        // console.log(response.data)
        this.rows = response.data
      })
    },
  },
}
</script>
