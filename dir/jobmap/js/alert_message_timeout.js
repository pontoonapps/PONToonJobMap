$(document).ready(function () {
    window.setTimeout(function () {
        $('.alert-success').fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 7000);
}); // ready() END

$(document).ready(function () {
    window.setTimeout(function () {
        $('.alert-primary').fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 7000);
}); // ready() END

$(document).ready(function () {
    window.setTimeout(function () {
        $('.alert-danger').fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 20000);
}); // ready() END

// $(document).ready(function () {
//     window.setTimeout(function () {
//         $('.alert-warning').fadeTo(500, 0).slideUp(500, function () {
//             $(this).remove();
//         });
//     }, 7000);
// });
// ready() END
