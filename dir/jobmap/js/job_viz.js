/* eslint-disable no-eval */
/* eslint-disable func-names */
/* eslint-disable no-redeclare */
/* eslint-disable no-undef */
/* eslint-disable prefer-destructuring */
/* eslint-disable no-var */
$(document).ready(() => {
  $('input[name=jobToggle]').change(function () {
    var mode = $(this).prop('checked');
    var id = $(this).val();
    $(`#jobStatusHead_${id}`).toggleClass('inactive');
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: '../../recruiters/jobs/toggle_job_viz.php',
      data: { mode, id },
      success(data) {
        var data = eval(data);
        // response_result=data.response_result;
        success = data.success;
        $(`#jobStatusHead_${id}`).html(success);
        $(`#jobStatusBody_${id}`).html(success);
        // $('#body').html(response_result);
      },
    });
  });
});
