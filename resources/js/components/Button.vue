<template>
  <button :class="classes" @click="click(data)">
        <span>
            <i class="feather icon-edit" aria-hidden="true"></i>
        </span>
    &nbsp;
    {{ name }}
  </button>
</template>

<script>
    export default {
        name: "Button",
        props: {
          data: {},
          name: {},
          click: {
            type: Function,
            default: () => {}
          },
          classes: {
            type: Object,
            default: () => ({
              'btn': true,
              'btn-primary': true,
              'btn-sm': false,
            }),
          },
        }
    }
</script>

<style>

</style>
