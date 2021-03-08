/* eslint-disable no-eval */
/* eslint-disable func-names */
/* eslint-disable no-redeclare */
/* eslint-disable no-undef */
/* eslint-disable prefer-destructuring */
/* eslint-disable no-var */
$(document).ready(() => {
  $('input[name=coToggle]').change(function () {
    var mode = $(this).prop('checked');
    var id = $(this).val();
    // $(`#coStatusHead_${id}`).toggleClass('inactive');
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: '../../recruiters/companies/toggle_co_viz.php',
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
