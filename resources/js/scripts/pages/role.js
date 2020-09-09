$(function () {
    $roleCreateForm = $("#role_create_form");
    if ($roleCreateForm) {
        $roleCreateForm.submit(function (evnt) {
            cleanForm();
            evnt.preventDefault();
            const url = $(this).attr('action');
            const formData = $(this).serialize();
            storeData(url, formData);
        });
    }

    $roleEditForm = $("#role_edit_form");
    if ($roleEditForm) {
        $roleEditForm.submit(function (evnt) {
            cleanForm();
            evnt.preventDefault();
            const url = $(this).attr('action');
            const formData = $(this).serialize();
            updateData(url, formData);
        });
    }

    async function storeData(url, formData) {
        try {
            const {data} = await axios.post(url, formData);
            if (data.success) {
                showSuccessAlert(data.success);
                setTimeout(() => {
                    window.location.href = "/settings/roles";
                }, 1000);
            }
        } catch (error) {
            const errors = error.response.data.errors;
            showErrors("#role_create_form", errors);
        }
    }

    async function updateData(url, formData) {
        try {
            const {data} = await axios.put(url, formData);
            if (data.success) {
                showSuccessAlert(data.success);
                setTimeout(() => {
                    window.location.href = "/settings/roles";
                }, 1000);
            }
        } catch (error) {
            const errors = error.response.data.errors;
            showErrors("#role_edit_form", errors);
        }
    }

    function showErrors(form, errors) {
        Object.keys(errors).forEach(function (key, value) {
            let $el = $(`${form} #${key}`);
            $el.addClass("is-invalid");
            $el.siblings(".invalid-feedback").text(errors[key][0]); 
         });
    }

    function showSuccessAlert(message) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          
        Toast.fire({
            icon: 'success',
            title: message
        });
    }

    function cleanForm() {
        $(".is-invalid").removeClass("is-invalid");
        $(".invalid-feedback").text('');
    }
});