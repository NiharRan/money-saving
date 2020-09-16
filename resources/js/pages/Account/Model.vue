<template>
  <div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modal-lg">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">{{ editMode ? __(`Update Information`) : __('Create New Account') }}</h3>
            <button type="button" class="close" @click="closeModal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="card-body">
            <form
              @submit.prevent="storeOrUpdate"
              method="POST"
              autocomplete="off">
              <div class="row">
                <div class="col-12">
                  <div class="border rounded px-1">
                    <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2"><i class="fa fa-info-circle mr-50 "></i> {{ __("Account Info") }}</h6>
                    <div class="row">
                      <div class="col-12 col-md-8">
                        <div class="form-group row">
                          <div class="col-12 col-md-6">
                            <label>{{ __("Name") }} <span class="text-danger">*</span></label>
                            <input
                              type="text"
                              v-model="form.name"
                              class="form-control"
                              :class="{'is-invalid': errors.name}"
                              :placeholder="__('Name')">
                            <div v-if="errors.name" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ errors.name }}</strong>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <label>{{ __("Slugan") }}</label>
                            <input
                              type="text"
                              v-model="form.slugan"
                              class="form-control"
                              :placeholder="__('Slugan')">
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-12 col-md-6">
                            <label>{{ __("Money Format") }} <span class="text-danger">*</span></label>
                            <multi-select
                              v-model="form.money_format"
                              :options="money_formats"
                              label="name"
                              track-by="name"
                              :searchable="true"
                              :class="{'is-invalid': errors.money_format_id}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select One') ">
                            </multi-select>
                            <div v-if="errors.money_format_id" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ errors.money_format_id }}</strong>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <label>{{ __("Account Type") }} <span class="text-danger">*</span></label>
                            <multi-select
                              v-model="form.account_type"
                              :options="account_types"
                              label="name"
                              track-by="name"
                              :searchable="true"
                              :disabled="editMode && !isDisabled"
                              :class="{'is-invalid': errors.account_type_id}"
                              :close-on-select="true"
                              :show-labels="false"
                              @input="checkAccountStatus"
                              :placeholder=" __('Select One') ">
                            </multi-select>
                            <div v-if="errors.account_type_id" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ errors.account_type_id }}</strong>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-12 col-md-12">
                            <label>{{ __("Members") }} <span class="text-danger">*</span></label>
                            <multi-select
                              v-model="form.users"
                              :options="users"
                              :multiple="true"
                              label="name"
                              track-by="name"
                              :searchable="true"
                              :disabled="isDisabled"
                              :class="{'is-invalid': errors.users}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select') ">
                            </multi-select>
                            <div v-if="errors.users" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ errors.users }}</strong>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 col-md-4">
                        <div class="banner-logo-upload-box passport-size mx-auto">
                          <img id="image_src" :src="form.imageUrl" alt="">
                          <label class="btn-pill">
                            <i class="fa fa-camera"></i>
                            <input id="image" type="file" @change="selectImage" name="avatar" class="hidden"/>
                          </label>
                        </div>
                        <div v-if="errors.logo" class="alert p-0 mt-1 alert-danger" role="alert">
                          <strong>{{ errors.logo }}</strong>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-success m-auto"> <i class="feather icon-plus"></i> {{ editMode ? __('Update') : __('Create') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
  export default {
    props: ['form', 'account_types', 'money_formats', 'users', 'editMode', 'isDisabled'],
    data() {
      return {
      }
    },
    methods: {
      storeOrUpdate () {
        if (this.editMode) {
          this.update();
        }else {
          this.store();
        }
      },
      checkAccountStatus: function (obj) {
        if (obj.name === 'Join') {
          this.isDisabled = false;
        }
      },
      store: async function () {
        let formData = new FormData;
        formData.append('name', this.form.name);
        formData.append('slugan', this.form.slugan);
        formData.append('logo', this.form.logo);
        const account_type_id = this.form.account_type !== null ?
          this.form.account_type.id : '';
        formData.append('account_type_id', account_type_id);

        const money_format_id = this.form.money_format !== null ?
          this.form.money_format.id : '';
        formData.append('money_format_id', money_format_id);

        const users = await this.form.users.map(function (user) {
          return user.id;
        });
        formData.append('users', users);
        if (!this.isDisabled && this.form.users.length === 0) {
          this.showToast(this.__('User is required'), 'Oops...', 'error', 'error');
        }
        try {
          const {data} = await axios.post('/api/accounts', formData);
          this.showToast(data.success);
          this.closeModal();
          this.$emit('refreshPage');
        }catch (error) {
          this.fillErrors(error.response.data.errors);
        }
      },
      update: async function () {
        let formData = new FormData;
        formData.append('name', this.form.name);
        formData.append('slugan', this.form.slugan);
        formData.append('logo', this.form.logo);
        const account_type_id = this.form.account_type !== null ?
          this.form.account_type.id : '';
        formData.append('account_type_id', account_type_id);

        const money_format_id = this.form.money_format !== null ?
          this.form.money_format.id : '';
        formData.append('money_format_id', money_format_id);

        const users = await this.form.users.map(function (user) {
          return user.id;
        });
        formData.append('users', users);
        if (!this.isDisabled && this.form.users.length === 0) {
          this.showToast(this.__('User is required'), 'Oops...', 'error', 'error');
        }
        try {
          const {data} = await axios.post(`/api/accounts/${this.form.id}`, formData);
          this.showToast(data.success);
          this.closeModal();
          this.$emit('refreshPage');
        }catch (error) {
          this.fillErrors(error.response.data.errors);
        }

      },
      showToast: function (text, title = 'Congratulations', icon = 'success', type = 'success') {
        this.$swal({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          icon: icon,
          type: type,
          title: title,
          text: text,
        });
      },
      selectImage: function (e) {
        const file = e.target.files[0];
        this.form.imageUrl = URL.createObjectURL(file);
        this.form.logo = file;
      },
      closeModal: function () {
        $("#modal").modal('hide')
      }
    },
    created() {
    },
  }
</script>
