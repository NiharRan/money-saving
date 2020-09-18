<template>
  <div>
    <breadcrumb :target="modelTarget"></breadcrumb>
    <div class="content-body">
      <section class="student-list-wrapper">
        <!-- customer create form section start -->
        <div id="dashboard-analytics">

          <div class="row">
            <!-- account info start -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-md-3 user-profile border-right">
                      <img :src="`/storage/users/thumbnail/medium/${user.avatar}`" class="w-100 rounded mb-2"
                           alt="avatar">
                      <h3>{{ user.name }}</h3>
                      <p class="mb-0">{{ user.phone }}</p>
                    </div>
                    <div class="col-md-6 col-12">
                      <table class="table table-bordered" v-if="transactionTypes.length > 0">
                        <tr v-for="transactionType in transactionTypes">
                          <td class="font-weight-bold">{{ transactionType.name }}</td>
                          <td>{{ transactionType.amount }}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-3 col-12 user-trans-btn">
                      <a :href="`/users/${user.slug}/transactions`" class="btn btn-primary"><i class="feather icon-plus"></i> {{ __('Transaction') }}</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- account info end -->

            <!-- account member info start -->
            <div class="col-12">
              <div class="row match-height" v-if="accounts.length > 0">
                <div class="col-12 col-md-6" v-for="account in accounts">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12 col-md-6 account-profile border-right">
                          <a :href="`/accounts/profile/${account.slug}`" class="w-100 rounded mb-2 text-center">
                            <img :src="`/storage/accounts/thumbnail/medium/${account.logo}`" alt="avatar">
                          </a>
                          <a :href="`/accounts/profile/${account.slug}`">
                            <h3>{{ account.name }}</h3>
                          </a>
                          <p class="mb-0">{{ account.slugan }}</p>
                        </div>
                        <div class="col-md-6 col-12">
                          <table class="table table-bordered" v-if="account.transactionTypes.length > 0">
                            <tr v-for="transactionType in account.transactionTypes">
                              <td class="font-weight-bold">{{  transactionType.name }}</td>
                              <td>{{  transactionType.amount }}</td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- account member info end -->

            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="mb-0">{{ __('Recent Transactions') }}</h4>
                </div>
                <div class="card-body">
                  <data-table
                    :data="data"
                    :columns="columns"
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
  import ButtonGroup from "../../components/ButtonGroup";
  import ProfileColumn from "../../components/ProfileColumn";
  import Invoice from "../../components/Invoice";

  export default {
    name: "UserProfile",
    data: function () {
      return {
        modelTarget: '',
        transactionUrl: '',
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
        user: {},
        transactionTypes: [],
        accounts: [],
        isLoading: false,
      }
    },
    methods: {
      reloadTable: function (tableProps) {
        if(this.transactionUrl !== '') {
          this.getData(this.transactionUrl, tableProps);
        }
      },
      getData: async function (url = this.url, options = this.tableProps) {
        const {data} = await axios.get(url, {
          params: options
        });
        this.data = data;
      },
      fetchUserInfo: async function (slug) {
        try {
          const {data} = await axios.get(`/api/users/profile/${slug}`);
          this.user = data.user;
          this.transactionTypes = data.transactionTypes;
          this.accounts = data.accounts;
          await this.getData(this.transactionUrl, this.tableProps);
        }catch (error) {
          console.log(error.response);
        }
      },
    },
    created() {
      const arr = window.location.href.split('/');
      const slug = arr[arr.length - 1];
      this.transactionUrl= `/api/users/${slug}/transactions`;
      this.fetchUserInfo(slug);
    },
  }
</script>

<style>
  .user-profile {
    align-items: center;
    display: flex;
    flex-direction: column;
  }

  .user-profile img {
    width: 40% !important;
  }

  .user-trans-btn {
    display: flex;
    flex-direction: column;
    align-self: center;
  }

  .user-trans-btn .btn {
    align-self: center;
    font-size: 20px;
  }
</style>
