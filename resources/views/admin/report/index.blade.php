@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endpush

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Report') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-sm-column flex-md-row justify-content-md-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{__('Report')}}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-data" width="100%" cellspacing="0">
                    <thead>
                        <th>Ticket No</th>
                        <th>City</th>
                        <th data-priority="1">Branch</th>
                        <th>Status</th>
                        <th>Report At</th>
                        <th class="action-data">Action</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal-form name="Set">
        //
    </x-modal-form>



@endsection

@push('plugins')
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}" ></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        var dtTable;
        $(document).ready(function() {

            //Data Table
            dtTable = $('#table-data').DataTable({
                responsive: true,
                processing : true,
                serverSide : true,
                ajax : 'report/data',
                columns : [
                    {data: 'ticket_no', name: 'ticket_no'},
                    {data : 'city', name : 'city'},
                    {data : 'branch', name : 'branch'},
                    {data : 'status', name : 'status'},
                    {data : 'created_at', name : 'created_at'},

                    {data : 'id', name: 'id'}
                ],
                columnDefs : [
                    {
                        targets : -1,
                        data : null,
                        width : "120px",
                        searchable : false,
                        orderable : false,
                        render : function(data, type, row) {
                            const callButton =  '<button class="btn btn-call btn-circle btn-sm btn-success" data-id=\'' + JSON.stringify(row) + '\' data-status="report_progress_customer_service_start_contact_customer" data-action="report/update">'
                                        +'<i class="fas fa-phone"></i>'
                                    +'</button>';

                            const hangButton =  '<button class="btn btn-process btn-circle btn-sm btn-danger" data-id=\'' + JSON.stringify(row) + '\' data-status="" data-action="report/update">'
                                        +'<i class="fas fa-phone"></i>'
                                    +'</button>';

                            if(row.status_value == 'report_progress_start'){
                                return callButton
                            }else if(row.status_value == 'report_progress_customer_service_start_contact_customer') {
                                return hangButton
                            }

                            return '';

                        }
                    }
                ]
            })

            $(document).on('click', '.btn-edit', function() {
                const form = $(this).attr('data-id')
                $('#modalTitle').html('Edit Data Worker')
                $('.form-control[name="full_name"]').val(JSON.parse(form).full_name)
                $('.form-control[name="phone"]').val(JSON.parse(form).phone)
                $('.form-control[name="email"]').val(JSON.parse(form).email)
                $('.form-control[name="username"]').val(JSON.parse(form).username)
                $('.form-control[name="password"]').parents('.form-group').hide()
                $('.form-control[name="password_confirmation"]').parents('.form-group').hide()
                optionData('/api/data-lokasi/city/select-data', 'select#city', JSON.parse(form).assignment_city_id, true)
                $('select#city').trigger('change')
                $('select#type').val(JSON.parse(form).type)
                $('select#type').trigger('change')
                $('#data-form-modal-table').attr('action', '/worker/' + JSON.parse(form).id)
                $('#modal-form-centered').modal('show')
                $('#btn-save').addClass("btn-save-edit")
            })

            $(document).on('click', '.btn-add', function() {
                $('#data-form-modal-table')[0].reset()
                $('#modalTitle').html('Create Technician')
                optionData('/api/data-lokasi/city/select-data', 'select#city', null, true)
                $('select#city').trigger('change')
                $('select#type').val()
                $('select#type').trigger('change')
                $('#data-form-modal-table').attr('action', '/worker')
                $('#modal-form-centered').modal('show')
                $('#btn-save').addClass("btn-save-new")
            })

            //Create or Update Global

            $('form').on('submit', function(e) {
                e.preventDefault()

                form = $(this).serialize()
                $.ajax({
                    url : $(this).attr('action'),
                    type : 'POST',
                    cache : false,
                    data : form,
                    success : function(data) {
                        toastr.success('Success !!')
                        $('#modal-form-centered').modal('hide')
                        dtTable.draw()
                    },
                    error : function(err) {
                        toastr.error('Error !!')
                    }
                })
            })

            //Delete Function Global

            $(document).on('click', 'button.btn-call', function(e) {
                e.preventDefault()

                Swal.fire({
                    icon : 'warning',
                    title : 'Update Report Status ?',
                    preConfirm : (res) => {
                    return fetch($(this).data('action'), {
                        method : 'POST',
                        headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        // 'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body : JSON.stringify({
                            id : $(this).data('id').id,
                            progress_code : $(this).data('status'),
                        })
                    })
                    .then(res => {
                        if(!res.ok) {
                            throw new Error(res.statusText)
                        }
                        toastr.success('Successfully Update Report Status!!')
                        dtTable.draw()
                    })
                    .catch(err => {
                        toastr.error("Error Updating Report Status!!")
                    })
                }
                })
            })


        })

    </script>
@endpush
