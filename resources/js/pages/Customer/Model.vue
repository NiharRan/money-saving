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
                            <label>{{ __("Contact No.") }} <span class="text-danger">*</span></label>
                            <input
                              type="text"
                              v-model="form.phone"
                              class="form-control"
                              :class="{'is-invalid': form.errors.has('phone')}"
                              :placeholder="__('Contact No.')">
                            <div v-if="form.errors.has('phone')" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ form.errors.get('phone') }}</strong>
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
                              :class="{'is-invalid': form.errors.has('gender')}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select One') ">
                            </multi-select>
                            <div v-if="form.errors.has('gender')" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ form.errors.get('gender') }}</strong>
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
                              :class="{'is-invalid': form.errors.has('account')}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select One') ">
                            </multi-select>
                            <div v-if="form.errors.has('account')" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ form.errors.get('account') }}</strong>
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
                              :class="{'is-invalid': form.errors.has('religion')}"
                              :close-on-select="true"
                              :show-labels="false"
                              :placeholder=" __('Select One') ">
                            </multi-select>
                            <div v-if="form.errors.has('religion')" class="alert p-0 mt-1 alert-danger" role="alert">
                              <strong>{{ form.errors.get('religion') }}</strong>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <label>{{ __("Email Address") }}</label>
                            <input
                              type="email"
                              v-model="form.email"
                              class="form-control"
                              :class="{'is-invalid': form.errors.has('email')}"
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
                        <div v-if="form.errors.has('avatar')" class="alert p-0 mt-1 alert-danger" role="alert">
                          <strong>{{ form.errors.get('avatar') }}</strong>
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
                        :class="{'is-invalid': form.errors.has('division')}"
                        :close-on-select="true"
                        :show-labels="false"
                        :placeholder=" __('Select One') "
                        @input="$emit('fetchDistricts')">
                      </multi-select>
                      <div v-if="form.errors.has('division')" class="alert p-0 mt-1 alert-danger" role="alert">
                        <strong>{{ form.errors.get('division') }}</strong>
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
                        :class="{'is-invalid': form.errors.has('district')}"
                        :close-on-select="true"
                        :show-labels="false"
                        :placeholder=" __('Select One') "
                        @input="$emit('fetchUpazillas')">
                      </multi-select>
                      <div v-if="form.errors.has('district')" class="alert p-0 mt-1 alert-danger" role="alert">
                        <strong>{{ form.errors.get('district') }}</strong>
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
                        :class="{'is-invalid': form.errors.has('upazilla')}"
                        :close-on-select="true"
                        :show-labels="false"
                        :placeholder=" __('Select One') ">
                      </multi-select>
                      <div v-if="form.errors.has('upazilla')" class="alert p-0 mt-1 alert-danger" role="alert">
                        <strong>{{ form.errors.get('upazilla') }}</strong>
                      </div>
                    </div>

                    <div class="col-12 col-md-3">
                      <label>{{ __("Village/House No.") }} <span class="text-danger">*</span></label>
                      <input
                        type="text"
                        v-model="form.address"
                        class="form-control"
                        :class="{'is-invalid': form.errors.has('address')}"
                        :placeholder="__('Village/House No.')">
                      <div v-if="form.errors.has('address')" class="alert p-0 mt-1 alert-danger" role="alert">
                        <strong>{{ form.errors.get('address') }}</strong>
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
    props: ['form', 'errors', 'accounts', 'genders', 'religions', 'divisions', 'districts', 'upazillas', 'editMode'],
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
        const {data} = await this.form.post('/api/customers');
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
        const {data} = await this.form.post(`/api/customers/${this.form.id}`);
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
        this.form.avatar = file;
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
