$(function () {
    $accountTypeField = $("#account_type_id");
    $usersField = $("#users");
    if ($accountTypeField) {
        $accountTypeField.change(function () {
            let el = $(this)[0];
            if (el.selectedIndex != -1) {
                let text = el.options[el.selectedIndex].text;
                if (text == 'Join') {
                    $usersField.prop('disabled', false);
                }else {
                    $usersField.val(null).trigger('change');
                    $usersField.prop('disabled', true);
                }
            }
        });
    }

    $logoField = $("#logo");
    if ($logoField) {
        $logoField.change(function (e) {
            const image = e.target.files[0];
            let image_url = URL.createObjectURL(image);
            $("#image_src").attr('src', image_url);
        });
    }

    $accountCreateForm = $("#account_create_form");
    if ($accountCreateForm) {
        $accountCreateForm.submit(function (e) {
            cleanForm();
            e.preventDefault();
            const url = $(this).attr('action');
            const formData = new FormData();
            const name = $(this).find('#name').val();
            const slugan = $(this).find('#slugan').val();
            const users = $(this).find('#users').val();
            const account_type_id = $(this).find('#account_type_id').val();
            const money_format_id = $(this).find('#money_format_id').val();
            const logoInput = $(this).find('#logo');

            formData.append('name', name);
            formData.append('slugan', slugan);
            formData.append('users', users);
            formData.append('account_type_id', account_type_id);
            formData.append('money_format_id', money_format_id);
            formData.append('logo', logoInput[0].files[0]);

            storeData(url, formData);
        });
    }

    $accountEditForm = $("#account_edit_form");
    if ($accountEditForm) {
        $accountEditForm.submit(function (e) {
            cleanForm();
            e.preventDefault();
            const url = $(this).attr('action');
            const formData = new FormData();
            const name = $(this).find('#name').val();
            const slugan = $(this).find('#slugan').val();
            const users = $(this).find('#users').val();
            const account_type_id = $(this).find('#account_type_id').val();
            const money_format_id = $(this).find('#money_format_id').val();
            const logoInput = $(this).find('#logo');

            formData.append('name', name);
            formData.append('slugan', slugan);
            formData.append('users', users);
            formData.append('account_type_id', account_type_id);
            formData.append('money_format_id', money_format_id);
            formData.append('logo', logoInput[0].files[0]);

            updateData(url, formData);
        });
    }


    $accountTransactionForm = $("#account_transaction_create_form");
    if ($accountTransactionForm) {
        $accountTransactionForm.submit(function (e) {
            cleanForm();
            e.preventDefault();
            const url = $(this).attr('action');
            const formData = $(this).serialize();
            storeTransactionData(url, formData);
        });
    }

    async function storeData(url, formData) {
        try {
            const {data} = await axios.post(url, formData);
            if (data.success) {
                showSuccessAlert(data.success);
                setTimeout(() => {
                    window.location.href = "/accounts";
                }, 1000);
            }
        } catch (error) {
            const errors = error.response.data.errors;
            showErrors("#account_create_form", errors);
        }
    }

    async function storeTransactionData(url, formData) {
        try {
            const {data} = await axios.post(url, formData);
            if (data.success) {
                showSuccessAlert(data.success);
                setTimeout(() => {
                    window.location.href = data.redirect_to;
                }, 1000);
            }
        } catch (error) {
            const errors = error.response.data.errors;
            showErrors("#account_transaction_create_form", errors);
        }
    }

    async function updateData(url, formData) {
        try {
            const {data} = await axios.put(url, formData);
            if (data.success) {
                showSuccessAlert(data.success);
                setTimeout(() => {
                    window.location.href = "/accounts";
                }, 1000);
            }
        } catch (error) {
            const errors = error.response.data.errors;
            showErrors("#account_edit_form", errors);
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