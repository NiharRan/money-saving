<template>
  <div>
    <breadcrumb :target="modelTarget"></breadcrumb>
    <div class="content-body">
      <section class="page-users-view">
        <div class="row">
          <!-- account info start -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-md-3 account-profile border-right">
                    <img :src="`/storage/accounts/thumbnail/medium/${account.logo}`" class="w-100 rounded mb-2"
                         alt="avatar">
                    <h3>{{ account.name }}</h3>
                    <p class="mb-0">{{ account.slugan }}</p>
                  </div>
                  <div class="col-md-6 col-12">
                    <table class="table table-bordered" v-if="transactionTypes.length > 0">
                      <tr v-for="transactionType in transactionTypes" :key="transactionType.id">
                        <td class="font-weight-bold">{{ transactionType.name }}</td>
                        <td>{{ transactionType.amount }}</td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-3 col-12 account-trans-btn">
                    <a :href="`/accounts/${account.id}/transactions`" class="btn btn-block btn-primary"><i class="feather icon-plus"></i> {{ __("Transaction") }}</a>
                    <a :href="`/accounts/${account.id}/loans`" class="btn btn-block btn-success"><i class="feather icon-plus"></i> {{ __("Loan") }}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- account info end -->

          <!-- account member info start -->
          <div class="col-12">
            <div class="row" v-if="users.length > 0">
              <div class="col-12 col-md-6" v-for="user in users" :key="user.id">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-6 account-profile border-right">
                        <a :href="`/profile/${user.slug}`" class="w-100 rounded mb-2 text-center">
                          <img :src="`/storage/users/thumbnail/medium/${user.avatar}`"  alt="avatar">
                        </a>
                        <h3><a :href="`/profile/${user.slug}`">{{ user.name }}</a></h3>
                        <p class="mb-0">{{ user.phone }}</p>
                      </div>
                      <div class="col-md-6 col-12">
                        <table class="table table-bordered" v-if="user.transactionTypes.length > 0">
                          <tr v-for="transactionType in user.transactionTypes" :key="transactionType.id">
                            <td class="font-weight-bold">{{ transactionType.name }}</td>
                            <td>{{ transactionType.amount }}</td>
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

          <!-- account transaction start -->
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __("Transactions") }}</h3>
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
          <!-- account transaction end -->
        </div>
      </section>
    </div>
  </div>
</template>

<script>
  import ButtonGroup from "../../components/ButtonGroup";
  import ProfileColumn from "../../components/ProfileColumn";
  import Invoice from "../../components/Invoice";

  export default {
    name: "AccountProfile",
    data: function () {
      return {
        transactionUrl: '',
        modelTarget: '',
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
            label: this.__('Member'),
            name: 'user',
            columnName: 'users.name',
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
        account: {},
        transactionTypes: [],
        users: [],
        isLoading: false,
      }
    },
    methods: {
      reloadTable: function (tableProps) {
        if (this.transactionUrl !== '') {
          this.getData(this.transactionUrl, tableProps);
        }
      },
      getData: async function (url = this.url, options = this.tableProps) {
        const {data} = await axios.get(url, {
          params: options
        });
        this.data = data;
      },
      fetchAccountInfo: async function (slug) {
        try {
          const {data} = await axios.get(`/api/accounts/profile/${slug}`);
          this.account = data.account;
          this.transactionTypes = data.transactionTypes;
          this.users = data.users;
          await this.getData(this.transactionUrl, this.tableProps);
        }catch (error) {
          console.log(error.response);
        }
      },
    },
    created() {
      const arr = window.location.href.split('/');
      const slug = arr[arr.length - 1];
      this.transactionUrl = `/api/accounts/${slug}/transactions`;
      this.fetchAccountInfo(slug);
    },
  }
</script>

<style>
  .account-profile {
    align-items: center;
    display: flex;
    flex-direction: column;
  }

  .account-profile img {
    width: 40% !important;
  }

  .account-trans-btn {
    display: flex;
    flex-direction: column;
    align-self: center;
  }

  .account-trans-btn .btn {
    align-self: center;
    font-size: 20px;
  }

</style>
