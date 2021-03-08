/* eslint-disable no-eval */
/* eslint-disable func-names */
/* eslint-disable no-redeclare */
/* eslint-disable no-undef */
/* eslint-disable prefer-destructuring */
/* eslint-disable no-var */
$(document).ready(() => {
  $('input[name=adminToggle]').change(function () {
    var mode = $(this).prop('checked');
    var id = $(this).val();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: '../../staff/admins/toggle_admin_viz.php',
      data: { mode, id },
      success(data) {
        var data = eval(data);
        // response_result=data.response_result;
        success = data.success;
        $(`#adminHeading_${id}`).html(success);
        // $('#body').html(response_result);
      },
    });
  });
});

$(document).ready(() => {
  $('input[name=userToggle]').change(function () {
    var mode = $(this).prop('checked');
    var id = $(this).val();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: '../../staff/admins/toggle_user_viz.php',
      data: { mode, id },
      success(data) {
        var data = eval(data);
        // response_result=data.response_result;
        success = data.success;
        $(`#userHeading_${id}`).html(success);
        // $('#body').html(response_result);
      },
    });
  });
});

$(document).ready(() => {
  $('input[name=recToggle]').change(function () {
    var mode = $(this).prop('checked');
    var id = $(this).val();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: '../../staff/admins/toggle_recruiter_viz.php',
      data: { mode, id },
      success(data) {
        var data = eval(data);
        // response_result=data.response_result;
        success = data.success;
        $(`#recHeading_${id}`).html(success);
        // $('#body').html(response_result);
      },
    });
  });
});

$(document).ready(() => {
  $('input[name=coToggle]').change(function () {
    var mode = $(this).prop('checked');
    var id = $(this).val();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: '../../staff/admins/toggle_co_viz.php',
      data: { mode, id },
      success(data) {
        var data = eval(data);
        // response_result=data.response_result;
        success = data.success;
        $(`#coStatusBody_${id}`).html(success);
        // $('#body').html(response_result);
        // window.setTimeout(function () {
        //   $('#coHeading').fadeTo(500, 0).slideUp(500, function () {
        //     $(this).remove();
        //   });
        // }, 3000);
      },
    });
  });
});

$(document).ready(() => {
  $('input[name=jobToggle]').change(function () {
    var mode = $(this).prop('checked');
    var id = $(this).val();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: '../../staff/admins/toggle_job_viz.php',
      data: { mode, id },
      success(data) {
        var data = eval(data);
        // response_result=data.response_result;
        success = data.success;
        $(`#jobHeading_${id}`).html(success);
        // $('#body').html(response_result);
      },
    });
  });
});
