@extends('layouts.admin')

@push('styles')

@endpush

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('City Data') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">{{__('List Of Cities')}}</h6>
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
                        <th>Country</th>
                        <th>Province</th>
                        <th>City</th>
                        <th>Same Day Service</th>
                        <th class="action-data">Action</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal-form name="City">
        <x-forms.select-ajax title="Country" name="country" />
        <x-forms.select-ajax title="Province" name="provinsi" />
        <x-forms.text title="Name" name="name" />
        <x-forms.select title="is Same Day Service" name="is_fast_service">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </x-forms.select>
    </x-modal-form>



@endsection

@push('plugins')
    <script>
        var dtTable;
        $(document).ready(function() {
            //Data Table
            dtTable = $('#table-data').DataTable({
                processing : true,
                serverSide : true,
                ajax : '/data-lokasi/city/data',
                columnDefs : [
                    {
                        data : 'country',
                        name : 'country',
                        targets : 0,
                    },
                    {
                        data : 'province',
                        name : 'province',
                        targets : 1
                    },
                    {
                        data : 'name',
                        name : 'name',
                        targets : 2
                    },
                    {
                        data : 'is_fast_service',
                        name : 'is_fast_service',
                        render : function(data, type, row, meta) {
                            return data === 1 ? 'Yes' : 'False';
                        },
                        targets : 3
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
                                    +'<button class="btn data-form-delete-button btn-sm btn-circle btn-danger" data-action="/data-lokasi/city/delete" data-id=\'' + JSON.stringify(row) + '\'>'
                                    +'<i class="fas fa-trash"></i>'
                                    +'</button>'
                        }
                    }
                ]
            })


            $(document).on('click', '.btn-edit', function() {
                const form = $(this).attr('data-id')
                const countries_id = JSON.parse(form).countries_id
                const provinces_id = JSON.parse(form).regions_id

                $('#modalTitle').html('Edit City')
                $('.form-control[name="name"]').val(JSON.parse(form).name)
                optionData('/api/data-lokasi/country/select-data', 'select#country', countries_id)
                optionData('/api/data-lokasi/province/select-data/' + countries_id, 'select#provinsi', provinces_id)
                $('#data-form-modal-table').attr('action', '/data-lokasi/city/' + JSON.parse(form).id)
                $('#modal-form-centered').modal('show')
                $('select#province').val(JSON.parse(form).regions_id)
                $('select#province').trigger('change')
                $('select#is_fast_service').val(JSON.parse(form).is_fast_service)
                $('select#is_fast_service').trigger('change')
                $('#btn-save').addClass("btn-save-edit")
            })

            $(document).on('click', '.btn-add', function() {
                $('#data-form-modal-table')[0].reset()
                $('#modalTitle').html('Create City')
                optionData('/api/data-lokasi/country/select-data', 'select#country')
                $('select#provinsi').html('<option selected="true" disabled="disabled">Choose Data</option>')
                $('#data-form-modal-table').attr('action', '/data-lokasi/city')
                $('#modal-form-centered').modal('show')
                $('#btn-save').addClass("btn-save-new")
                $('select#country').val()
                $('select#country').trigger('change')
                $('select#province').val()
                $('select#province').trigger('change')
                $('select#is_fast_service').val()
                $('select#is_fast_service').trigger('change')
            })

            //Update On Select
            $('select#country').on('change', function() {
                optionData('/api/data-lokasi/province/select-data/' + $(this).val(), 'select#provinsi')
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
