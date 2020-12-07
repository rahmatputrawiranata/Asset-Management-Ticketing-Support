@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endpush

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Provinsi') }}</h1>

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
                    <h6 class="m-0 font-weight-bold text-primary">{{__('Data Provinsi')}}</h6>
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
                        <th>Negara</th>
                        <th>Nama</th>
                        <th class="action-data">Action</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal-form name="Data Negara Kita">
        <x-forms.select-ajax title="Negara" name="country" />
        <x-forms.text title="Nama Provinsi" name="name" />
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
                ajax : '/data-lokasi/region/data',
                columnDefs : [
                    {
                        data : 'countries',
                        name : 'countries',
                        targets : 0
                    },
                    {
                        data : 'name',
                        name : 'name',
                        targets : 1
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
                                    +'<button class="btn data-form-delete-button btn-sm btn-circle btn-danger" data-action="/data-lokasi/country/delete" data-id=\'' + JSON.stringify(row) + '\'>'
                                    +'<i class="fas fa-trash"></i>'
                                    +'</button>'
                        }
                    }
                ]
            })


            $(document).on('click', '.btn-edit', function() {
                const form = $(this).attr('data-id')
                optionData('/api/data-lokasi/country/select-data', 'select#country', JSON.parse(form).countries_id)
                $('#modalTitle').html('Edit Data Provinsi')
                $('input[name="name"]').val(JSON.parse(form).name)
                $('#data-form-modal-table').attr('action', '/data-lokasi/region/' + JSON.parse(form).id)
                $('#modal-form-centered').modal('show')
                $('select#country').val(JSON.parse(form).countries_id)
                $('select#country').trigger('change')
                $('#btn-save').addClass("btn-save-edit")
            })

            $(document).on('click', '.btn-add', function() {
                $('#data-form-modal-table')[0].reset()
                optionData('/api/data-lokasi/country/select-data', 'select#country')
                $('#modalTitle').html('Buat Data Provinsi')
                $('#data-form-modal-table').attr('action', '/data-lokasi/region')
                $('#modal-form-centered').modal('show')
                $('#btn-save').addClass("btn-save-new")
                $('select#country').val()
                $('select#country').trigger('change')
            })


        })

    </script>
@endpush
