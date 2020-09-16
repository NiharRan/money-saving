<template>
  <div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb" v-if="bc.length > 0">
<!--              this will load breadcrumbs dynamically from controller-->
              <li
                class="breadcrumb-item"
                v-for="(breadcrumb, key) in bc"
                :key="key">
                <a :href="[breadcrumb.link ? breadcrumb.link : '']">
                  {{ breadcrumb.name ? breadcrumb.name : '' }}
                </a>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div v-if="flag" class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
      <button type="button" class="btn btn-primary" @click="showModel"><i class="feather icon-plus"></i> {{ lt }}</button>
    </div>
  </div>

</template>

<script>
    export default {
      name: "Breadcrumb",
      props: ['target'],
      data: function () {
        return {
          flag: false,
          lt: '',
          bc: []
        }
      },
      created() {
        if (this.hasText()) {
          this.flag = true;
          this.lt = this.linkText()
        }
        this.bc = this.breadcrumbs();
      },
      methods: {
        showModel: function () {
          $(this.target).modal('show');
        }
      }
    }
</script>

<style>

</style>
