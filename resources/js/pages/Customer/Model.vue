<template>
  <div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modal-lg">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">{{ editMode ? __('') : __('Create New Customer') }}</h3>
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
                              :class="{'is-invalid': errors.name}"
                              :placeholder="__('Name')">
                            <div v-if="errors.name" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ errors.name }}</strong>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <label>{{ __("Contact No.") }} <span class="text-danger">*</span></label>
                            <input
                              type="text"
                              v-model="form.phone"
                              class="form-control"
                              :class="{'is-invalid': errors.phone}"
                              :placeholder="__('Contact No.')">
                            <div v-if="errors.phone" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ errors.phone }}</strong>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-12 col-md-6">
                            <label>{{ __("Gender") }} <span class="text-danger">*</span></label>
                            <multi-select
                              v-model="form.gender"
                              :options="genders"
                              label="name"
                              track-by="name"
                              :searchable="true"
                              :class="{'is-invalid': errors.gender_id}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select One') ">
                            </multi-select>
                            <div v-if="errors.gender_id" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ errors.gender_id }}</strong>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <label>{{ __("Account") }} <span class="text-danger">*</span></label>
                            <multi-select
                              v-model="form.account"
                              :options="accounts"
                              label="name"
                              track-by="name"
                              :searchable="true"
                              :class="{'is-invalid': errors.account_id}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select One') ">
                            </multi-select>
                            <div v-if="errors.account_id" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ errors.account_id }}</strong>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-12 col-md-6">
                            <label>{{ __("Religion") }} <span class="text-danger">*</span></label>
                            <multi-select
                              v-model="form.religion"
                              :options="religions"
                              label="name"
                              track-by="name"
                              :searchable="true"
                              :class="{'is-invalid': errors.religion_id}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select One') ">
                            </multi-select>
                            <div v-if="errors.religion_id" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ errors.religion_id }}</strong>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <label>{{ __("Email Address") }}</label>
                            <input
                              type="email"
                              v-model="form.email"
                              class="form-control"
                              :class="{'is-invalid': errors.email}"
                              :placeholder="__('Email Address')">
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
                        <div v-if="errors.avatar" class="alert p-0 mt-1 alert-danger" role="alert">
                          <strong>{{ errors.avatar }}</strong>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group row">
                    <div class="col-12 col-md-3">
                      <label>{{ __("Division") }} <span class="text-danger">*</span></label>
                      <multi-select
                        v-model="form.division"
                        :options="divisions"
                        label="name"
                        track-by="name"
                        :searchable="true"
                        :class="{'is-invalid': errors.division_id}"
                        :close-on-select="true"
                        :show-labels="false"
                        :placeholder=" __('Select One') "
                        @input="$emit('fetchDistricts')">
                      </multi-select>
                      <div v-if="errors.division_id" class="alert p-0 mt-1 alert-danger" role="alert">
                        <strong>{{ errors.division_id }}</strong>
                      </div>
                    </div>
                    <div class="col-12 col-md-3">
                      <label>{{ __("District") }} <span class="text-danger">*</span></label>
                      <multi-select
                        v-model="form.district"
                        :options="districts"
                        label="name"
                        track-by="name"
                        :searchable="true"
                        :class="{'is-invalid': errors.district_id}"
                        :close-on-select="true"
                        :show-labels="false"
                        :placeholder=" __('Select One') "
                        @input="$emit('fetchUpazillas')">
                      </multi-select>
                      <div v-if="errors.district_id" class="alert p-0 mt-1 alert-danger" role="alert">
                        <strong>{{ errors.district_id }}</strong>
                      </div>
                    </div>
                    <div class="col-12 col-md-3">
                      <label>{{ __("Upazilla") }} <span class="text-danger">*</span></label>
                      <multi-select
                        v-model="form.upazilla"
                        :options="upazillas"
                        label="name"
                        track-by="name"
                        :searchable="true"
                        :class="{'is-invalid': errors.upazilla_id}"
                        :close-on-select="true"
                        :show-labels="false"
                        :placeholder=" __('Select One') ">
                      </multi-select>
                      <div v-if="errors.upazilla_id" class="alert p-0 mt-1 alert-danger" role="alert">
                        <strong>{{ errors.upazilla_id }}</strong>
                      </div>
                    </div>

                    <div class="col-12 col-md-3">
                      <label>{{ __("Village/House No.") }} <span class="text-danger">*</span></label>
                      <input
                        type="text"
                        v-model="form.address"
                        class="form-control"
                        :class="{'is-invalid': errors.address}"
                        :placeholder="__('Village/House No.')">
                      <div v-if="errors.address" class="alert p-0 mt-1 alert-danger" role="alert">
                        <strong>{{ errors.address }}</strong>
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
    props: ['form', 'accounts', 'genders', 'religions', 'divisions', 'districts', 'upazillas', 'editMode'],
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
        let formData = new FormData;
        formData.append('name', this.form.name);
        formData.append('phone', this.form.phone);
        formData.append('avatar', this.form.avatar);
        formData.append('address', this.form.address);

        const gender_id = this.form.gender !== null ?
          this.form.gender.id : '';
        formData.append('gender_id', gender_id);

        const account_id = this.form.account !== null ?
          this.form.account.id : '';
        formData.append('account_id', account_id);

        const religion_id = this.form.religion !== null ?
          this.form.religion.id : '';
        formData.append('religion_id', religion_id);

        const division_id = this.form.division !== null ?
          this.form.division.id : '';
        formData.append('division_id', division_id);

        const district_id = this.form.district !== null ?
          this.form.district.id : '';
        formData.append('district_id', district_id);

        const upazilla_id = this.form.upazilla !== null ?
          this.form.upazilla.id : '';
        formData.append('upazilla_id', upazilla_id);

        try {
          const {data} = await axios.post('/api/customers', formData);
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
        formData.append('phone', this.form.phone);
        formData.append('avatar', this.form.avatar);
        formData.append('address', this.form.address);

        const gender_id = this.form.gender !== null ?
          this.form.gender.id : '';
        formData.append('gender_id', gender_id);

        const account_id = this.form.account !== null ?
          this.form.account.id : '';
        formData.append('account_id', account_id);

        const religion_id = this.form.religion !== null ?
          this.form.religion.id : '';
        formData.append('religion_id', religion_id);

        const division_id = this.form.division !== null ?
          this.form.division.id : '';
        formData.append('division_id', division_id);

        const district_id = this.form.district !== null ?
          this.form.district.id : '';
        formData.append('district_id', district_id);

        const upazilla_id = this.form.upazilla !== null ?
          this.form.upazilla.id : '';
        formData.append('upazilla_id', upazilla_id);
        try {
          const {data} = await axios.post(`/api/customers/${this.form.id}`, formData);
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
        this.form.avatar = file;
      },
      closeModal: function () {
        this.errors = {};
        $("#modal").modal('hide')
      }
    },
    mounted() {
    },
  }
</script>
