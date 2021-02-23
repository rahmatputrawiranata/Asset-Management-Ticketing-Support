@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endpush

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Problem Details') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">{{__('Problem Details/Indication')}}</h6>
                    <div>
                        <button class="btn btn-primary btn-add btn-icon-split" type="button" >
                            <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                            <span class="text">Add</span>
                        </button>
                    </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-data" width="100%" cellspacing="0">
                    <thead>
                        <th>No. </th>
                        <th>Problem Details/Indication</th>
                        <th>Item Problem</th>
                        <th>Category</th>
                        <th>Severity</th>
                        <th class="action-data">Action</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>‹

    <x-modal-form name="Data Set Up Kind Of Damage Device Kita">
        <x-forms.text title="Item Details" name="name" />
        <x-forms.select-ajax title="Item" name="item_id"/>
        <x-forms.select
            title="Category"
            name="category"
        >
            <option value="hardware">Hardware</option>
            <option value="software">Software</option>
        </x-forms.select>
        <x-forms.select-ajax title="Severity" name="severity_configuration_id"/>
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
                processing : true,
                serverSide : true,
                ajax : 'kind-of-damage-type/data',
                columns : [
                    {data : 'DT_RowIndex', name : 'DT_RowIndex', "width" : "5%"},
                    {data : 'name', name : 'name'},
                    {data : 'item', name : 'item'},
                    {data : 'category', name : 'category'},
                    {data : 'severity', name : 'severity'},
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
                            return  '<button class="btn btn-edit btn-circle btn-sm btn-primary" data-id=\'' + JSON.stringify(row) + '\'>'
                                    +'<i class="fas fa-pen"></i>'
                                    +'</button> '
                                    +'<button class="btn data-form-delete-button btn-sm btn-circle btn-danger" data-action="/kind-of-damage-type/delete" data-id=\'' + JSON.stringify(row) + '\'>'
                                    +'<i class="fas fa-trash"></i>'
                                    +'</button>'
                        }
                    }
                ]
            })

            $(document).on('click', '.btn-edit', function() {
                const form = $(this).attr('data-id')
                $('#modalTitle').html('Edit Set Up Kind Of Damage Device Device')
                optionData('/item/data/select', 'select#item_id', JSON.parse(form).item_id)
                optionData('/severity/data/select', 'select#severity_configuration_id', JSON.parse(form).severity_configuration_id)
                $('select#category').val(JSON.parse(form).category)
                $('select#category').trigger('change')
                $('.form-control[name="name"]').val(JSON.parse(form).name)
                $('#data-form-modal-table').attr('action', '/kind-of-damage-type/' + JSON.parse(form).id)
                $('#modal-form-centered').modal('show')
                $('#btn-save').addClass("btn-save-edit")

            })

            $(document).on('click', '.btn-add', function() {
                $('#data-form-modal-table')[0].reset()
                optionData('/item/data/select', 'select#item_id')
                optionData('/severity/data/select', 'select#severity_configuration_id')
                $('select#category').val('hardware')
                $('select#category').trigger('change')
                $('#modalTitle').html('Buat Set Up Kind Of Damage Device Device')
                $('#data-form-modal-table').attr('action', '/kind-of-damage-type')
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
