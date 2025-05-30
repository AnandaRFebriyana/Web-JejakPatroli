// get edit jadwal shift
$(document).ready(function () {
    $('.shiftModalEditLink').on('click', function () {
        var shiftId = $(this).data('shift-id');
        console.log('Id:', shiftId);
        
        $.ajax({
            url: '/schedules/shift/' + shiftId + '/edit',
            type: 'GET',
            success: function(data) {
                console.log('Data:', data);
                $('#shiftModalEdit #shift_name').val(data.shift_name);
                $('#shiftModalEdit #start_time').val(data.start_time);
                $('#shiftModalEdit #end_time').val(data.end_time);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        $('#shift_id').val(shiftId);
        $('#formEdit').attr('action', '/schedules/shift/' + shiftId);
        $('#updateModal').modal('show');
    });
});

// get edit location
$(document).ready(function () {
    $('.locModalEditLink').on('click', function () {
        var locationId = $(this).data('location-id');
        console.log('Id:', locationId);
        
        $.ajax({
            url: '/location/' + locationId + '/edit',
            type: 'GET',
            success: function(data) {
                console.log('Data:', data);
                $('#locModalEdit #location_name').val(data.location_name);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        $('#location_id').val(locationId);
        $('#formEdit').attr('action', '/location/' + locationId);
        $('#updateModal').modal('show');
    });
});

// get change password
$(document).ready(function () {
    $('.passModalEditLink').on('click', function () {
        var guardId = $(this).data('guard-id');
        console.log('Id:', guardId);
        
        $.ajax({
            url: '/guard/' + guardId + '/account',
            type: 'GET',
            success: function(data) {
                console.log('Data:', data);
                $('#passModalEdit #email').val(data.email);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        $('#guard_id').val(guardId);
        $('#formEdit').attr('action', '/guard/update/' + guardId);
        $('#passModalEdit').modal('show');
    });

    // Validasi password
    $('#formEdit').on('submit', function(e) {
        var password = $('#password').val();
        var passwordConfirmation = $('#password_confirmation').val();
        
        if (password !== passwordConfirmation) {
            e.preventDefault();
            $('#password_confirmation').addClass('is-invalid');
            $('#password_confirmation').next('.invalid-feedback').html('Konfirmasi password tidak cocok');
            return false;
        }
    });
});

function handleFormSubmit(formId, modalId) {
    $(formId).on('submit', function (event) {
        event.preventDefault();
        var form = $(this);
        var formData = form.serialize();
        
        removeFormErrors(formId);

        $.ajax({
            url: form.attr('action'),
            type: form.find('input[name="_method"]').val() || 'POST',
            data: formData,
            success: function(response) {
                $(modalId).modal('hide');
                swal({
                    title: "Berhasil!",
                    text: response.success,
                    icon: "success",
                    button: "OK",
                    timer: 1500,
                });
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    displayFormErrors(formId, errors);
                } else {
                    console.error(xhr.responseText);
                }
            }
        });
    });

    $(modalId).on('hidden.bs.modal', function () {
        removeFormErrors(formId);
    });
}


function displayFormErrors(formId, errors) {
    for (const [key, value] of Object.entries(errors)) {
        const input = $(formId + ' [name="' + key + '"]');
        input.addClass('is-invalid');
        input.next('.invalid-feedback').html(value[0]);
    }
}

function removeFormErrors(formId) {
    $(formId + ' .form-control').removeClass('is-invalid');
    $(formId + ' .invalid-feedback').html('');
}

handleFormSubmit('#shiftModal form', '#shiftModal');
handleFormSubmit('#locModal form', '#locModal');
handleFormSubmit('#formEdit', '#passModalEdit');
handleFormSubmit('#shiftModalEdit form', '#shiftModalEdit');
handleFormSubmit('#locModalEdit form', '#locModalEdit');