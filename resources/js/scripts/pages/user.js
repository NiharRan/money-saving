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
