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

        <user-model
          :form="form"
          :accounts="accounts"
          :genders="genders"
          :religions="religions"
          :divisions="divisions"
          :districts="districts"
          :upazillas="upazillas"
          :editMode="editMode"
          v-on:fetchDistricts="fetchDistricts"
          v-on:fetchUpazillas="fetchUpazillas"
          v-on:refreshPage="reloadTable"
        ></user-model>

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
    import UserModel from './Model';
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    import swal from '../../plugins/sweetalert';

    export default {
        name: "List",
        components: {
          UserModel,
          Loading,
          Breadcrumb
        },
        data: function () {
          return {
            modelTarget: "#modal",
            url: '/api/customers',
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
                label: this.__('Contact No.'),
                name: 'phone',
                orderable: true,
              },
              {
                label: this.__('Email Address'),
                name: 'email',
                orderable: true,
              },
              {
                label: this.__('Gender'),
                name: 'gender.name',
                columnName: 'genders.name',
                orderable: true,
              },
              {
                label: this.__('Religion'),
                name: 'religion.name',
                columnName: 'religions.name',
                orderable: true,
              },
              {
                label: this.__('Account'),
                name: 'account.name',
                columnName: 'accounts.name',
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
            data: {},
            form: {
              id: '',
              name: '',
              phone: '',
              avatar: null,
              imageUrl: '/storage/customers/default.png',
              email: '',
              account: null,
              gender: null,
              religion: null,
              division: null,
              district: null,
              upazilla: null,
              address: ''
            },
            accounts: [],
            genders: [],
            religions: [],
            divisions: [],
            districts: [],
            upazillas: [],
            editMode: false,
            isLoading: false,
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
            const {data} = await axios.delete(`/api/customers/${obj.id}`);
            swal.success(data.success);
          }else {
            swal.success(this.__('Data is safe :)'), 'Cancelled', 'error');
          }
        },
        showModal: function (data) {
          this.editMode = true;
          this.form.id = data.id;
          this.form.name = data.name;
          this.form.phone = data.phone;
          this.form.email = data.email;
          this.form.address = data.address;
          this.form.imageUrl =`/storage/customers/${data.avatar}`;
          this.form.account = data.account;
          this.form.gender = data.gender;
          this.form.religion = data.religion;
          this.form.division = data.division;
          this.form.district = data.district;
          this.form.upazilla = data.upazilla;
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
        fetchAuthAccounts: async function () {
          try {
            const {data} = await axios.get(`/api/users/${this.auth('id')}/accounts/?status=1`);
            this.accounts = data;
          }catch (e) {
            console.log(e.response.data);
          }
        },
        fetchGenders: async function () {
          try {
            const {data} = await axios.get(`/api/genders/?status=1`);
            this.genders = data;
          }catch (e) {
            console.log(e.response.data);
          }
        },
        fetchReligions: async function () {
          try {
            const {data} = await axios.get(`/api/religions/?status=1`);
            this.religions = data;
          }catch (e) {
            console.log(e.response.data);
          }
        },
        fetchDivisions: async function () {
          try {
            const {data} = await axios.get(`/api/divisions/?status=1`);
            this.divisions = data;
          }catch (e) {
            console.log(e.response.data);
          }
        },
        fetchDistricts: async function () {
          if (this.form.division !== null) {
            let division_id = this.form.division.id;
            try {
              const {data} = await axios.get(`/api/districts/?status=1&division_id=${division_id}`);
              this.districts = data;
            }catch (e) {
              console.log(e.response.data);
            }
          }
        },
        fetchUpazillas: async function () {
          if (this.form.district !== null) {
            let district_id = this.form.district.id;
            try {
              const {data} = await axios.get(`/api/upazillas/?status=1&district_id=${district_id}`);
              this.upazillas = data;
            }catch (e) {
              console.log(e.response.data);
            }
          }
        },
      },
      created: function() {
          this.getData(this.url, this.tableProps);
          this.fetchAuthAccounts();
          this.fetchGenders();
          this.fetchReligions();
          this.fetchDivisions();
      }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
