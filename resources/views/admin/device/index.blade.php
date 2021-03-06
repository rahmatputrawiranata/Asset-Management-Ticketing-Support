@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endpush

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Device') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">{{__('Data Device')}}</h6>
                    <div>
                        <button class="btn btn-primary btn-add btn-icon-split" type="button" >
                            <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                            <span class="text">Add</span>
                        </button>
                    </div>
            </div>
        </div>
        <div class="card-body">
            {{-- <svg class="barcode" jsbarcode-format="upc" jsbarcode-value="Lenovo" jsbarcode-textmargin="0" jsbarcode-fontoptions="bold"> </svg> --}}
            {{-- <svg id="barcode"></svg> --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="table-data" width="100%" cellspacing="0">
                    <thead>
                        <th>No. </th>
                        <th>Serial Number</th>
                        <th class="none">Barcode</th>
                        <th>Device Model</th>
                        <th class="action-data">Action</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal-form name="Data Device Kita">
        <x-forms.text title="Serial Number" name="device_code" />
        <x-forms.text title="Device Model" name="device_model" />
        <x-forms.text-area title="Spesification" name="spesification" />
        <x-forms.text-area title="Notes" name="notes" />
        <x-forms.select-ajax title="Problem List" name="problem_details" :multiple="true" />
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
                responsive : true,
                'fnDrawCallback' : function(oSettings){
                    JsBarcode(".barcode").init();
                },
                'fnInitComplete' : function(oSettings, json) {
                    JsBarcode(".barcode").init();
                },
                processing : true,
                serverSide : true,
                ajax : 'device/data',
                columns : [
                    {data : 'DT_RowIndex', name : 'DT_RowIndex', "width" : "5%"},
                    {data : 'device_code', name : 'device_code'},
                    {data : null, name : null},
                    {data : 'device_model', name : 'device_model'},
                    {data : 'id', name: 'id'}
                ],
                columnDefs : [
                    {
                        data : null,
                        targets : 2,
                        searchable : false,
                        orderable : false,
                        render:function(data,type,row) {
                            return '<svg class="barcode"'
                                        +'jsbarcode-format="auto"'
                                        +'jsbarcode-value=\''+ row.device_code +'\''
                                        +'jsbarcode-textmargin="0"'
                                        +'jsbarcode-width="1"'
                                        +'jsbarcode-fontoptions="bold">'
                        }
                    },
                    {
                        targets : -1,
                        data : null,
                        width : "120px",
                        searchable : false,
                        orderable : false,
                        render : function(data, type, row) {
                            return  '<button class="btn btn-edit btn-circle btn-sm btn-primary" data-id=\'' + JSON.stringify(row) + '\'>'
                                    +'<i class="fas fa-pen"></i>'
                                    +'</button> '
                                    +'<button class="btn data-form-delete-button btn-sm btn-circle btn-danger" data-action="/device/delete" data-id=\'' + JSON.stringify(row) + '\'>'
                                    +'<i class="fas fa-trash"></i>'
                                    +'</button>'
                        }
                    }
                ]
            })

            dtTable.on('responsive-display', function() {
                JsBarcode(".barcode").init();
            })



            $(document).on('click', '.btn-edit', function() {
                const form = $(this).attr('data-id')
                console.log(form);
                $('#modalTitle').html('Edit Data Device')
                $('.form-control[name="device_code"]').val(JSON.parse(form).device_code)
                $('.form-control[name="device_model"]').val(JSON.parse(form).device_model)
                $('.form-control[name="spesification"]').val(JSON.parse(form).spesification)
                $('.form-control[name="notes"]').val(JSON.parse(form).notes)
                optionData('/api/problem-details/select-data', 'select#problem_details', JSON.parse(form).assignment_problem_details_id, true)
                $('select#problem_details').trigger('change')
                $('#data-form-modal-table').attr('action', '/device/' + JSON.parse(form).id)
                $('#modal-form-centered').modal('show')
                $('#btn-save').addClass("btn-save-edit")
            })

            $(document).on('click', '.btn-add', function() {
                $('#data-form-modal-table')[0].reset()
                $('#modalTitle').html('Buat Data Device')
                $('#data-form-modal-table').attr('action', '/device')
                optionData('/api/problem-details/select-data', 'select#problem_details', null, true)
                $('select#problem_details').trigger('change')
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

            $(document).on('click', 'button.data-form-delete-button', function(e) {
                e.preventDefault()

                Swal.fire({
                    icon : 'warning',
                    title : 'Konfirmasi Delete Data',
                    text : 'Apakah anda yakin ingin menghapus data ini!!',
                    preConfirm : (res) => {
                    return fetch($(this).data('action'), {
                        method : 'POST',
                        headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        // 'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body : JSON.stringify({
                            id : $(this).data('id').id
                        })
                    })
                    .then(res => {
                        if(!res.ok) {
                            throw new Error(res.statusText)
                        }
                        toastr.success('Successfully Delete Data!!')
                        dtTable.draw()
                    })
                    .catch(err => {
                        toastr.error("Error Deleting data!!")
                    })
                }
                })
            })


        })

    </script>
@endpush
