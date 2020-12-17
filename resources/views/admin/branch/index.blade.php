@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Cabang') }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-sm-column flex-md-row justify-content-md-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{__('Data Cabang')}}</h6>
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
                        <th>#</th>
                        <th>Kota</th>
                        <th>Code</th>
                        <th>Nama Cabang</th>
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
        <x-forms.select-ajax title="Provinsi" name="provinsi" />
        <x-forms.select-ajax title="Kota" name="kota" />
        <x-forms.text title="Code" name="code" />
        <x-forms.text title="Nama Kota" name="name" />
        <x-forms.text-area title="Alamat Detail" name="address"/>
        <x-forms.select-ajax title="Enginer On Site" name="enginer_on_site"/>
        <x-forms.select-ajax title="People In Charge" name="pic"/>
        <x-forms.select-ajax title="People In Charge GA" name="pic_ga"/>
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
                ajax : '/data-lokasi/branch/data',
                columns : [

                        {data : 'id', name : 'id'},
                        {data : 'city', name : 'city'},
                        {data : 'code', name : 'code'},
                        {data : 'name', name : 'name'},
                        {
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

            //Add Code

            $(document).on('click', '.btn-add', function() {
                $('#data-form-modal-table')[0].reset()
                optionData('/api/data-lokasi/country/select-data', 'select#country')
                $('#modalTitle').html('Buat Data Cabang')
                $('#data-form-modal-table').attr('action', '/data-lokasi/region')
                $('#modal-form-centered').modal('show')
                $('#btn-save').addClass("btn-save-new")
                $('select#country').val()
                $('select#country').trigger('change')
                $('select#provinsi').trigger('change')
                $('select#kota').trigger('change')
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

            //Update On Select
            $('select#country').on('change', function() {
                $('select#provinsi').html('<option selected="true" disabled="disabled" value="0">Chose Data</option>')
                $('select#kota').html('<option selected="true" disabled="disabled" value="0">Chose Data</option>')
                optionData('/api/data-lokasi/province/select-data/' + $(this).val(), 'select#provinsi')
            })

            $('select#provinsi').on('change', function() {
                $('select#kota').val()
                optionData('/api/data-lokasi/city/select-data/' + $(this).val(), 'select#kota')
            })




        })
    </script>
@endpush
