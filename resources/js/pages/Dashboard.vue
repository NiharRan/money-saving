<template>
  <div>
    <div class="content-body">
      <section class="student-list-wrapper">
        <!-- customer create form section start -->
        <div id="dashboard-analytics">
          <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="card bg-analytics text-white">
                <div class="card-content">
                  <div class="card-body text-center">
                    <img src="/images/elements/decore-left.png" class="img-left" alt="card-img-left">
                    <img src="/images/elements/decore-right.png" class="img-right" alt="card-img-right">
                    <div class="avatar avatar-xl bg-primary shadow mt-0">
                      <div class="avatar-content">
                        <i class="feather icon-award white font-large-1"></i>
                      </div>
                    </div>
                    <div class="text-center">
                      <h1 class="mb-2 text-white">{{ __("Congratulations :name", auth('name')) }},</h1>
                      <p class="m-auto w-75">You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                  <div class="avatar bg-rgba-primary p-50 m-0">
                    <div class="avatar-content">
                      <i class="feather icon-users text-primary font-medium-5"></i>
                    </div>
                  </div>
                  <h2 class="text-bold-700 mt-1 mb-25">92.6k</h2>
                  <p class="mb-0">Subscribers Gained</p>
                </div>
                <div class="card-content">
                  <div id="subscribe-gain-chart"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
              <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                  <div class="avatar bg-rgba-warning p-50 m-0">
                    <div class="avatar-content">
                      <i class="feather icon-package text-warning font-medium-5"></i>
                    </div>
                  </div>
                  <h2 class="text-bold-700 mt-1 mb-25">97.5K</h2>
                  <p class="mb-0">Orders Received</p>
                </div>
                <div class="card-content">
                  <div id="orders-received-chart"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="mb-0">{{ __('Recent Transactions') }}</h4>
                </div>
                <div class="card-body">
                  <data-table
                    :data="data"
                    :url="url"
                    :columns="auth('is_admin') ? allColumns : columns"
                    @on-table-props-changed="reloadTable"
                    @loading="isLoading = true"
                    @finished-loading="isLoading = false">
                    <div slot="pagination" slot-scope="{ links = {}, meta = {} }">
                      <nav class="row">
                        <div class="col-md-6 text-left">
                          <span>
                              Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }} Entries
                          </span>
                        </div>
                        <div class="col-md-6 text-right">
                          <button
                            :disabled="!links.prev"
                            class="btn btn-primary btn-sm"
                            @click="url = links.prev">
                            {{ __('Prev') }}
                          </button>
                          <button
                            :disabled="!links.next"
                            class="btn btn-primary btn-sm ml-2"
                            @click="url = links.next">
                            {{ __('Next') }}
                          </button>
                        </div>
                      </nav>
                    </div>
                  </data-table>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- Dashboard end -->
      </section>
    </div>
  </div>
</template>

<script>
    import ButtonGroup from "../components/ButtonGroup";
    import ProfileColumn from "../components/ProfileColumn";
    import Invoice from "../components/Invoice";

    export default {
      name: "Dashboard",
      data: function () {
          return {
            url: '/api/transactions',
            data: {},
            tableProps: {
              search: '',
              length: 10,
              column: 'id',
              dir: 'desc'
            },
            columns: [
              {
                label: this.__('S.N.'),
                name: 'id',
                orderable: true,
              },
              {
                label: this.__('Account'),
                name: 'account',
                columnName: 'accounts.name',
                orderable: true,
                event: "",
                handler: this.actionHandler,
                component: ProfileColumn,
              },
              {
                label: this.__('Invoice'),
                name: 'invoice',
                orderable: true,
                event: "",
                handler: this.actionHandler,
                component: Invoice,
              },
              {
                label: this.__('Amount'),
                name: 'amount',
                orderable: true,
              },
              {
                label: this.__('Transaction Type'),
                name: 'transaction_type.name',
                columnName: 'transaction_types.name',
                orderable: true,
              },
              {
                label: this.__('Date'),
                name: 'trans_date',
                orderable: true,
              },
              {
                label: this.__('Action'),
                orderable: false,
                event: "click",
                handler: this.actionHandler,
                component: ButtonGroup,
              },
            ],
            allColumns: [
              {
                label: this.__('S.N.'),
                name: 'id',
                orderable: true,
              },
              {
                label: this.__('Invoice'),
                name: 'invoice',
                orderable: true,
                event: "",
                handler: this.actionHandler,
                component: Invoice,
              },
              {
                label: this.__('Member'),
                name: 'user',
                columnName: 'users.name',
                orderable: true,
                event: "",
                handler: this.actionHandler,
                component: ProfileColumn,
              },
              {
                label: this.__('Amount'),
                name: 'amount',
                orderable: true,
              },
              {
                label: this.__('Transaction Type'),
                name: 'transaction_type.name',
                columnName: 'transaction_types.name',
                orderable: true,
              },
              {
                label: this.__('Account'),
                name: 'account',
                columnName: 'accounts.name',
                orderable: true,
                event: "",
                handler: this.actionHandler,
                component: ProfileColumn,
              },
              {
                label: this.__('Date'),
                name: 'trans_date',
                orderable: true,
              },
              {
                label: this.__('Action'),
                orderable: false,
                event: "click",
                handler: this.actionHandler,
                component: ButtonGroup,
              },
            ],
            isLoading: false,
          }
      },
      methods: {
        reloadTable: function (tableProps) {
          this.getData(this.url, tableProps);
        },
        getData: async function (url = this.url, options = this.tableProps) {
          const {data} = await axios.get(url, {
            params: options
          });
          this.data = data;
        },
      },
      created() {
        this.getData(this.url, this.tableProps);
      },
    }
</script>

<style>

</style>
