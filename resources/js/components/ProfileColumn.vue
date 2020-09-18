<template>
  <div class="media">
    <a v-if="name === 'user'" :href="`/profile/${data.user.slug}`" class="d-flex">
      <img class="mr-1 card-img img-sm" :src="`/storage/users/thumbnail/small/${data.user.avatar}`" alt="Generic placeholder image">
      <div class="media-body">
        <h5 class="mt-0">{{ data.user.name }}</h5>
      </div>
    </a>

    <a v-if="name === 'account'" :href="`/accounts/profile/${data.account.slug}`" class="d-flex">
      <img class="mr-1 card-img img-sm" :src="`/storage/accounts/thumbnail/small/${data.account.logo}`" alt="Generic placeholder image">
      <div class="media-body">
        <h5 class="mt-0">{{ data.account.name }}</h5>
      </div>
    </a>
  </div>
</template>

<script>
    export default {
        name: "ProfileColumn",
        props: {
          data: {},
          name: {},
          data_of: {},
          click: {
            type: Function,
            default: () => {}
          },
        }
    }
</script>

<style>

</style>
