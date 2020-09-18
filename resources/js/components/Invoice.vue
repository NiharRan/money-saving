<template>
  <p class="text-center text-bold-700">
    {{data.invoice | invoice_format(data)}}
  </p>
</template>

<script>
    export default {
        name: "Invoice",
        props: {
          data: {},
          name: {},
          data_of: {},
          click: {
            type: Function,
            default: () => {}
          },
        },
      filters: {
        invoice_format: function (invoice, data) {
          const inv = invoice+'';
          const firstPart = data.user.name.substr(0, 3).toUpperCase();
          const secondPart = inv.padStart(4,"0");
          return `${firstPart}-${secondPart}`;
        }
      }
    }
</script>

<style>

</style>
