$(document).ready(function () {
  $('#form_saved_data_contact').on('submit', function (event) {
    if (!event.target.checkValidity()) {
      event.preventDefault()
      event.stopPropagation()
    }
    $(this).addClass('was-validated')
  })

  // -----------------------------Guardar datos de contacto---------------------------

  $('#form_saved_data_contact').on('submit', function (event) {
    var prospect_name = $('#prospect_name').val()
    var prospect_contact = $('#prospect_contact').val()
    var prospect_message = $('#prospect_message').val()

    if (
      prospect_name == '' ||
      prospect_contact == '' ||
      prospect_message == ''
    ) {
      return false
    }

    $.ajax({
      contentType: 'application/json; charset=UTF-8',
      data: JSON.stringify({
        name: prospect_name,
        phone: prospect_contact,
        message: prospect_message
      }),
      type: 'POST',
      dataType: 'json',
      url: 'https://www.gnssys.com/api/homepage',

      success: function (response) {
        if (response.hasOwnProperty('status')) {
          if (response.status == '200') {
            $('#form_saved_data_contact').each(function () {
              this.reset()
            })
            $('#form_saved_data_contact')
              .trigger('reset')
              .removeClass('was-validated')
            swal(
              '!  Muy bien ! ',
              'En breve nos pondremos en contacto con usted !',
              'success'
            )
          } else {
            swal(
              'Intentelo más tarde!',
              'No se ha podido enviar el mensaje',
              'warning'
            )
          }
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        swal('Intentelo más tarde!', '', 'warning')
      }
    })

    return true
  }) //---------------------------------------Fin guardar datos contacto------------------------------------
})
