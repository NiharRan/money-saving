<template>
  <div>
    <breadcrumb :target="modelTarget"></breadcrumb>
    <div class="content-body">
      <section class="student-list-wrapper">
        <!-- customer create form section start -->
        <div id="basic-examples">
          <div class="card">
            <div class="card-content collapse show">
              <div class="card-body">
                <data-table
                  :data="data"
                  :url="url"
                  :columns="columns"
                  @on-table-props-changed="reloadTable"
                  @loading="isLoading = true"
                  @finished-loading="isLoading = false">
                </data-table>
              </div>
            </div>
          </div>
        </div>

        <account-model
          :form="form"
          :account_types="account_types"
          :money_formats="money_formats"
          :users="users"
          :editMode="editMode"
          :isDisabled="isDisabled"
          v-on:refreshPage="reloadTable"
        ></account-model>

        <loading
          :is-full-page="false"
          :active.sync="isLoading">
        </loading>
        <!-- customer create form section end -->
      </section>
    </div>
  </div>
</template>

<script>
    import Breadcrumb from "../../panels/Breadcrumb";
    import ButtonGroup from "../../components/ButtonGroup";
    import AccountModel from './Model';
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    import swal from '../../plugins/sweetalert';
    export default {
        name: "AccountList",
        components: {
          AccountModel,
          Loading,
          Breadcrumb
        },
        data: function () {
          return {
            modelTarget: "#modal",
            url: '/api/accounts',
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
                label: this.__('Name'),
                name: 'name',
                orderable: true,
              },
              {
                label: this.__('Slugan'),
                name: 'slugan',
                orderable: true,
              },
              {
                label: this.__('Account Type'),
                name: 'account_type.name',
                columnName: 'account_types.name',
                orderable: true,
              },
              {
                label: this.__('Money Format'),
                name: 'money_format.name',
                columnName: 'money_formats.name',
                orderable: true,
              },
              {
                label: this.__('Action'),
                classes: "text-center",
                orderable: false,
                editText: this.__('Edit'),
                event: "click",
                handler: this.actionHandler,
                component: ButtonGroup,
              },
            ],
            data: {},
            form: {
              id: '',
              name: '',
              logo: null,
              imageUrl: '/storage/accounts/default.png',
              account_type: null,
              money_format: null,
              users: [],
              slugan: '',
            },
            account_types: [],
            money_formats: [],
            users: [],
            editMode: false,
            isLoading: false,
            isDisabled: true,
          }
        },
      methods: {
        actionHandler: function (data, action) {
          if(action === 'edit') {
            this.showModal(data);
          }
          if (action === 'delete') {
            this.destroy(data);
          }
        },
        destroy: async function (obj) {
          if(await swal.confirm(this.__("You won't be able to revert this!"))) {
            const {data} = await axios.delete(`/api/accounts/${obj.id}`);
            swal.success(data.success);
          }else {
            swal.success(this.__('Data is safe :)'), 'Cancelled', 'error');
          }
        },
        showModal: function (data) {
          if (typeof data.account_type.name !== "undefined" && data.account_type.name === 'Join') {
            this.isDisabled = false;
          }
          this.editMode = true;
          this.form.id = data.id;
          this.form.name = data.name;
          this.form.slugan = data.phone;
          this.form.imageUrl =`/storage/accounts/${data.logo}`;
          this.form.account_type = data.account_type;
          this.form.money_format = data.money_format;
          this.form.users = data.users;
          $("#modal").modal('show')
        },
        getData: async function (url = this.url, options = this.tableProps) {
          const {data} = await axios.get(url, {
            params: options
          });
          this.data = data;
        },
        reloadTable(tableProps) {
          this.getData(this.url, tableProps);
        },
        fetchAccountTypes: async function () {
          try {
            const {data} = await axios.get(`/api/account-types/search/?status=1`);
            this.account_types = data;
          }catch (e) {
            console.log(e.response.data);
          }
        },
        fetchMoneyFormats: async function () {
          try {
            const {data} = await axios.get(`/api/money-formats/?status=1`);
            this.money_formats = data;
          }catch (e) {
            console.log(e.response.data);
          }
        },
        fetchSubscribers: async function () {
          try {
            const {data} = await axios.get(`/api/users/search?status=1&role=Subscriber`);
            this.users = data;
          }catch (e) {
            console.log(e.response.data);
          }
        }
      },
      created: function() {
          this.getData(this.url, this.tableProps);
          this.fetchSubscribers();
          this.fetchAccountTypes();
          this.fetchMoneyFormats();
      }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
