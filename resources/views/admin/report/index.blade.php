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
                        <th>Ticket ID</th>
                        <th>Report Time</th>
                        <th>City</th>
                        <th data-priority="1">Branch</th>


                        <th>Item Problem</th>
                        <th>Status</th>
                        <th class="action-data">Action</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal-form name="Process Report">
        <input type="hidden" name="id"/>
        <input type="hidden" name="progress_code"/>
        <x-forms.select title="Select Resolution" name="resolution">
            <option value="report_progress_system_deploy_worker">Looking for Technician</option>
            <option value="report_progress_done">Set To Finish</option>
        </x-forms.select>
        <x-forms.select-ajax title="Problem Details" name="kind_of_damage_type_id"/>
        <x-forms.text-area title="Note" name="notes"/>
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
                    {data: 'item_problem', name : 'item_problem'},
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
                            const callButton =  '<button class="btn btn-call btn-process  btn-sm btn-success" data-id=\'' + JSON.stringify(row) + '\' data-status="report_progress_validation_by_Admin" data-action="report/update">'
                                        +'<i class="fas fa-phone"></i> Process Report'
                                    +'</button>';

                            const processButton =  '<button class="btn btn-sm btn-primary" data-id=\'' + JSON.stringify(row) + '\' data-status="report_progress_system_deploy_worker" data-action="report/update">'
                                        +'Process Report'
                                    +'</button>';

                            if(row.status_value == 'report_progress_start'){
                                return callButton
                            }else if(row.status_value == 'report_progress_validation_by_Admin') {
                                return processButton
                            }else if(row.status_value == 'report_progress_system_deploy_worker'){
                                return '<a href="#" class="btn btn-danger" btn-sm btn-primary">in Qeueu Worker</a>'
                            }else if(row.status_value == 'report_progress_done'){
                                return '<a href="#" class="btn btn-success" btn-sm btn-primary">Finish</a>'
                            }

                            return '';

                        }
                    }
                ]
            })

            $(document).on('click', '.btn-process', function() {
                const form = $(this).attr('data-id')
                const formData = JSON.parse(form)
                $("input[name='id']").val(formData.id)
                $("input[name='progress_code']").val($(this).attr('data-status'))
                $('#data-form-modal-table')[0].reset()
                $('#modalTitle').html('Process Report')
                optionData('/api/problem-details/select-data/' + formData.device_id, 'select#kind_of_damage_type_id', formData.kind_of_damage_type_id)
                $('#modal-form-centered').modal('show')
                $('#data-form-modal-table').attr('action', '/report/update')
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

            // $(document).on('click', 'button.btn-call', function(e) {
            //     e.preventDefault()

            //     Swal.fire({
            //         icon : 'warning',
            //         title : 'Update Report Status ?',
            //         preConfirm : (res) => {
            //         return fetch($(this).data('action'), {
            //             method : 'POST',
            //             headers: {
            //             'Content-Type': 'application/json',
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             // 'Content-Type': 'application/x-www-form-urlencoded',
            //             },
            //             body : JSON.stringify({
            //                 id : $(this).data('id').id,
            //                 progress_code : $(this).data('status'),
            //             })
            //         })
            //         .then(res => {
            //             if(!res.ok) {
            //                 throw new Error(res.statusText)
            //             }
            //             toastr.success('Successfully Update Report Status!!')
            //             dtTable.draw()
            //         })
            //         .catch(err => {
            //             toastr.error("Error Updating Report Status!!")
            //         })
            //     }
            //     })
            // })


        })

    </script>
@endpush
