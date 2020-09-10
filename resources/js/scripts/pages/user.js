$(function () {
  // datepicker for birth date
  if ($("#birth_date")) {
    $("#birth_date").datepicker({
      format: 'yy-mm-dd'
    });
  }
  // if district is already selected then fetch district with selected old one
  if ($("#old_district_id")) {
    let district_id = $("#old_district_id").val();
    let upazilla_id = $("#old_upazilla_id").val();
    let division_id = $("#division_id").val();
    if(division_id != '') {
      fetchDistricts(division_id, district_id);
      fetchUpazillas(district_id, upazilla_id);
    }
  }
  // fetch district when division selected
  if ($("#division_id")) {
    $("#division_id").on('change', function () {
      $("#district_id").append('<option value="">Select ..</option>');
      var division_id = $(this).val();
      if (division_id != '') fetchDistricts(division_id);
    });
  }
  async function fetchDistricts(division_id, district_id='')
  {
    let {data} = await axios.post('/settings/districts/find', {
      division_id: division_id,
      district_id: district_id
    });
    $("#district_id").append(data);
  }

  // fetch upazilla when district selected
  if ($("#district_id")) {
    $("#district_id").on('change', function () {
      $("#upazilla_id").append('<option value="">Select ..</option>');
      let district_id = $(this).val();
      if (district_id != '') fetchUpazillas(district_id);
    });
  }
  async function fetchUpazillas(district_id, upazilla_id='')
  {
    let {data} = await axios.post('/settings/upazillas/find', {
      district_id: district_id,
      upazilla_id: upazilla_id,
    });
    $("#upazilla_id").append(data);
  }


  // show image when image selected
  if ($("#image")) {
    $("#image").change(function (e) {
      let image = e.target.files[0];
      let image_url = URL.createObjectURL(image);
      $("#image_src").attr('src', image_url);
    });
  }
});

$(function () {
  let $avatarField = $("#avatar");
  if ($avatarField) {
    $avatarField.change(function (e) {
      const image = e.target.files[0];
      let image_url = URL.createObjectURL(image);
      $("#image_src").attr('src', image_url);
    });
  }



  let $userTransactionForm = $("#user_transaction_create_form");
  if ($userTransactionForm !== undefined) {
    $userTransactionForm.submit(function (e) {
      cleanForm();
      e.preventDefault();
      const url = $(this).attr('action');
      const formData = $(this).serialize();
      storeTransactionData(url, formData);
    });
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
      showErrors("#user_transaction_create_form", errors);
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
