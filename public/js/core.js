
    $(document).ready(function() {
        //core ajax for form
        $(document).on('submit', '#data-form-modal-table', function(e) {
            e.preventDefault()
            const formData = $(this).serializeArray()
            $.ajax({
                url : $(this).attr('action'),
                type : 'POST',
                data : formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend : function() {
                    $("#btn-save").prop('disabled', true)
                },
                success : function() {
                    $("#modal-form-centered").modal("hide")
                    $("#btn-save").prop('disabled', false)
                    dtTable.ajax.reload()
                },
                error : function(e) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                    $("#btn-save").prop('disabled', false)
                }
            })
        })

        $(document).on('click', '.data-form-delete-button', function(e) {
            const dataForm = JSON.parse($(this).attr('data-id'))
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : $(this).attr('data-action'),
                        type : 'POST',
                        data : {
                            id :dataForm.id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend : function() {
                            $("#btn-save").prop('disabled', true)
                        },
                        success : function() {
                            $("#modal-form-centered").modal("hide")
                            $("#btn-save").prop('disabled', false)
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            dtTable.ajax.reload()
                        },
                        error : function(e) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                            })
                            swal("Error", "Error Aja Ya", "error")
                        }
                    })

                }
              })

        })
    })
