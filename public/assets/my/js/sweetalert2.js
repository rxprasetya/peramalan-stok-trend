$(function () {
    $(document).on('click', '#delete', function (e) {
        e.preventDefault()
        let link = $(this).attr("href")

        console.log(link);

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success py-2 px-3 me-3",
                cancelButton: "btn btn-danger py-2 px-3"
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: link,
                    type: 'GET',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        }).then(() => {
                            location.reload()
                        })
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error"
                        })
                    }
                })
            }
        })
    })
})

$(document).ready(function () {
    // Cek apakah ada pesan sukses dalam session
    const successMessage = $('body').data('success-message')
    const errorMessage = $('body').data('error-message')

    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Succeed!',
            text: successMessage,
            confirmButtonText: 'OK',
        })
    }

    if (errorMessage) {
        Swal.fire({
            title: "Error!",
            text: errorMessage,
            icon: "error"
        })
    }
})
