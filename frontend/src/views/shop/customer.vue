<template>
  <div class="row">
    <div class="col-12">
      <b-card>
        <b-card-header>
          <h4 class="card-title">Customer</h4>
          <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="primary" to="/">
            Add New
          </b-button>
        </b-card-header>
        <b-card-body>
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
              :columns="columns"
              :rows="rows"
              :search-options="{
        enabled: true,
        externalQuery: searchTerm }"
              :pagination-options="{
        enabled: true,
        perPage:pageLength
      }"
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
                <span>Edit</span>
              </b-dropdown-item>
              <b-dropdown-item>
                <feather-icon
                    icon="TrashIcon"
                    class="mr-50"
                />
                <span>Delete</span>
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
        </b-card-body>
      </b-card>
    </div>
  </div>
</template>

<script>
import Ripple from 'vue-ripple-directive'
import { VueGoodTable } from 'vue-good-table'
import '@core/scss/vue/libs/vue-good-table.scss'
import axiosIns from '@/libs/axios';

export default {
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
          label: 'Phone Number',
          field: 'phone_number',
        },
        {
          label: 'Description',
          field: 'description',
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
    axiosIns.get('api/v1/shop/customer').then(response => {
      console.log(response.data)
      this.rows = response.data
    })
  },
}
</script>