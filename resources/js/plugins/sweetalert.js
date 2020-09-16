import Vue from 'vue';
import VueSweetalert2 from "vue-sweetalert2";

Vue.use(VueSweetalert2);

let swalWithBootstrapButtons = Vue.swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
});

export default {
  confirm: async function(text) {
    let result = await swalWithBootstrapButtons.fire({
      title: 'Are you sure?',
      text: text,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    });
    return result.isConfirmed;
  },
  success: function (msg, title = 'Success', icon = 'success') {
    swalWithBootstrapButtons.fire(
      title,
        msg,
      icon
    )
  }
}
