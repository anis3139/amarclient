<template>
  <b-row>
    <b-col cols="12">
      <div class="card">
        <div class="card-header">
          <span class="card-title">Invoice List</span>
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
            ref="saleTable"
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
            <template slot="table-row" slot-scope="props">
              <!-- Column: ID -->
              <span v-if="props.column.field === 'id'" class="text-nowrap">
                <span class="text-nowrap">{{ props.row.id }}</span>
              </span>

              <!-- Column: Name -->
              <span v-if="props.column.field === 'Name'" class="text-nowrap">
                <b-avatar :src="props.row.avatar" class="mx-1" />
                <span class="text-nowrap">{{ props.row.name }}</span>
              </span>

              <!-- Column: Name -->
              <span v-if="props.column.field === 'start_date'" class="text-nowrap">
                <span class="text-nowrap">{{moment(props.row.start_date).format('Do MMMM, YYYY')}}</span>
              </span>

              <!-- Column: Action -->
              <span v-else-if="props.column.field === 'action'">
                <span>
                  <router-link :to="{name:'shop.invoice.preview',params:{id:props.row.id}}">
                    <feather-icon icon="EyeIcon" size="16" class="mx-1 cursor" />
                  </router-link>
                </span>
                <span>
                  <b-dropdown variant="link" toggle-class="text-decoration-none" no-caret>
                    <template v-slot:button-content>
                      <feather-icon
                        icon="MoreVerticalIcon"
                        size="16"
                        class="text-body align-middle mr-25"
                      />
                    </template>

                    <b-dropdown-item>
                      <feather-icon icon="TrashIcon" class="mr-50" />
                      <span>
                        <router-link :to="{name:'shop.invoice.edit',params:{id:props.row.id}}">Edit</router-link>
                      </span>
                    </b-dropdown-item>

                    <b-dropdown-item>
                      <feather-icon icon="TrashIcon" class="mr-50" />
                      <span>
                        <router-link
                          :to="{name:'shop.invoice.preview',params:{id:props.row.id}}"
                        >Preview</router-link>
                      </span>
                    </b-dropdown-item>
                  </b-dropdown>
                </span>
              </span>

              <!-- Column: Common -->
              <span v-else>{{ props.formattedRow[props.column.field] }}</span>
            </template>

            <!-- pagination -->
            <template slot="pagination-bottom" slot-scope="props">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-center mb-0 mt-1">
                  <span class="text-nowrap">Showing 1 to</span>
                  <b-form-select
                    v-model="pageLength"
                    :options="['10','20','50']"
                    class="mx-1"
                    @input="(value)=>props.perPageChanged({currentPerPage:value})"
                  />
                  <span class="text-nowrap">of {{ props.total }} entries</span>
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
                      <feather-icon icon="ChevronLeftIcon" size="18" />
                    </template>
                    <template #next-text>
                      <feather-icon icon="ChevronRightIcon" size="18" />
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
import Ripple from "vue-ripple-directive";
import { VueGoodTable } from "vue-good-table";
import "@core/scss/vue/libs/vue-good-table.scss";
import axiosIns from "@/libs/axios";

export default {
  name: "Index",
  components: {
    VueGoodTable
  },

  directives: {
    Ripple
  },
  data() {
    return {
      pageLength: 10,
      dir: false,
      columns: [
        {
          label: "ID",
          field: "id"
        },
        {
          label: "Client",
          field: "name"
        },
        {
          label: "Total",
          field: "amount"
        },
        {
          label: "ISSUED DATE",
          field: "start_date"
        },

        {
          label: "BALANCE",
          field: "due_payment"
        },
        {
          label: "Action",
          field: "action"
        }
      ],
      rows: [],
      searchTerm: ""
    };
  },
  computed: {},
  created() {
    this.getSaleData();
  },
  methods: {
    getSaleData() {
      axiosIns.get("api/v1/shop/sale").then(response => {
         const rows = [];
        response.data.sale.forEach((element, i) => {
          console.log(element.client[0].name);
          rows.push({
            id: element.id,
            due_payment: element.due_payment,
            amount: element.amount,
            amount: element.amount,
            start_date: element.start_date,
            name: (element.client_id == element.client[0].id) ? element.client[0].name : "0",
          });
        });
        this.rows = rows;
      });
    }
  }
};
</script>

<style scoped>
.cursor {
  cursor: pointer;
}
</style>
