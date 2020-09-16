<template>
  <div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modal-lg">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">{{ editMode ? `${form.name}'এর তথ্য পরিবর্তন করুন` : 'নতুন ব্যবহারকারী তৈরি করুন' }}</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="card-body">
            <form
              @submit.prevent="storeOrUpdate"
              @keydown="form.onKeydown($event)"
              method="POST"
              autocomplete="off">
              <div class="row">
                <div class="col-12">
                  <div class="border rounded px-1">
                    <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2"><i class="fa fa-info-circle mr-50 "></i> {{ __("Customer Info") }}</h6>
                    <div class="row">
                      <div class="col-12 col-md-8">
                        <div class="form-group row">
                          <div class="col-12 col-md-6">
                            <label>{{ __("Name") }} <span class="text-danger">*</span></label>
                            <input
                              type="text"
                              v-model="form.name"
                              class="form-control"
                              :class="{'is-invalid': form.errors.has('name')}"
                              :placeholder="__('Name')">
                            <div v-if="form.errors.has('name')" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ form.errors.get('name') }}</strong>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <label>{{ __("Slugan") }} <span class="text-danger">*</span></label>
                            <input
                              type="text"
                              v-model="form.phone"
                              class="form-control"
                              :class="{'is-invalid': form.errors.has('phone')}"
                              :placeholder="__('Slugan')">
                            <div v-if="form.errors.has('phone')" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ form.errors.get('phone') }}</strong>
                            </div>
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
                              :class="{'is-invalid': form.errors.has('money_format')}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select One') ">
                            </multi-select>
                            <div v-if="form.errors.has('money_format')" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ form.errors.get('money_format') }}</strong>
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
                              :class="{'is-invalid': form.errors.has('account_type')}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select One') ">
                            </multi-select>
                            <div v-if="form.errors.has('account_type')" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ form.errors.get('account_type') }}</strong>
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
                              :class="{'is-invalid': form.errors.has('users')}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select') ">
                            </multi-select>
                            <div v-if="form.errors.has('users')" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ form.errors.get('users') }}</strong>
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
                        <div v-if="form.errors.has('logo')" class="alert p-0 mt-1 alert-danger" role="alert">
                          <strong>{{ form.errors.get('logo') }}</strong>
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
    props: ['form', 'account_types', 'money_formats', 'users', 'editMode'],
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
      store: async function () {
        const {data} = await this.form.post('/api/accounts');
        this.$swal({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          icon: 'success',
          type: 'success',
          title: 'Congratulations',
          text: data.success,
        });
        this.closeModal();
        this.$emit('refreshPage');
      },
      update: async function () {
        const {data} = await this.form.post(`/api/accounts/${this.form.id}`);
        this.$swal({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          icon: 'success',
          type: 'success',
          title: 'Congratulations',
          text: data.success,
        });
        this.closeModal();
        this.$emit('refreshPage');
      },
      selectImage: function (e) {
        const file = e.target.files[0];
        this.form.imageUrl = URL.createObjectURL(file);
        this.form.logo = file;
      },
      closeModal: function () {
        this.form.reset();
        $("#modal").modal('hide')
      }
    },
    mounted() {
    },
  }
</script>
