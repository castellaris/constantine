$(document).ready(function () {
    $('#registrationForm').on('submit', function (e) {
      e.preventDefault();
  
      $.ajax({
        type: 'POST',
        url: 'connection.php',
        data: $(this).serialize(),
        success: function (response) {
          $('#responseMessage')
            .removeClass('alert-danger')
            .addClass('alert-success')
            .html(response)
            .show();
        },
        error: function () {
          $('#responseMessage')
            .removeClass('alert-success')
            .addClass('alert-danger')
            .html('An error occurred. Please try again.')
            .show();
        },
      });
    });
  });
  