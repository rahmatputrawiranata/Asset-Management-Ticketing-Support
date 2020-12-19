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

    <x-modal-form name="Data Cabang">
        <x-forms.select-ajax title="Negara" name="country" />
        <x-forms.select-ajax title="Provinsi" name="provinsi" />
        <x-forms.select-ajax title="Kota" name="kota" />
        <x-forms.text title="Code" name="code" />
        <x-forms.text title="Nama Cabang" name="name"/>
        <x-forms.text title="Enginer On Site" name="eos"/>
        <x-forms.text title="Enginer On Site Phone Number" name="eos_number"/>
        <x-forms.text title="People In Charge" name="pic"/>
        <x-forms.text title="People In Charge Phone Number" name="pic_number"/>
        <x-forms.text title="People In Charge GA" name="pic_ga"/>
        <x-forms.text title="People In Charge GA Phone Number" name="pic_ga_number"/>
        <x-forms.text-area title="Alamat Detail" name="address"/>
        <x-forms.map/>
    </x-modal-form>

@endsection

@push('plugins')
    <script>

        // Map Box

        mapboxgl.accessToken = 'pk.eyJ1IjoieXVuaWFyZHMiLCJhIjoiY2tjcmpmMHBxMDZidjJ6bzRkajl5Mzg4aSJ9.Spqh3c8-cTVHpCeHfz-AMw';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center : [106.865036, -6.175110], //long , lat
            zoom : 14
        });

        var marker = new mapboxgl.Marker({
            draggable : true,
        })
        .setLngLat([106.865036, -6.175110])
        .addTo(map)

        var geocoder = new MapboxGeocoder({
            accessToken : mapboxgl.accessToken,
            mapboxgl : mapboxgl,
            marker : false
        })

        map.addControl(geocoder)

        marker.on('dragend', function(res) {
            const center = res.target._lngLat
            mapboxSetCenter(center.lng, center.lat)
        })

        geocoder.on('result', function(ev) {
            mapboxSetCenter(ev.result.center[0], ev.result.center[1])
        });

        function mapboxSetCenter(long, lat) {
            map.flyTo({
                center : [
                    long, lat
                ]
            })
            marker.setLngLat([long, lat])

            $('input[name=latitude]').val(lat)
            $('input[name=longitude]').val(long)
        }

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
                                        +'<button class="btn data-form-delete-button btn-sm btn-circle btn-danger" data-action="/data-lokasi/branch/delete" data-id=\'' + JSON.stringify(row) + '\'>'
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
                $('#data-form-modal-table').attr('action', '/data-lokasi/branch')
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
                optionData('/api/data-lokasi/province/select-data/' + JSON.parse(form).province_id, 'select#provinsi', JSON.parse(form).province_id)
                optionData('/api/data-lokasi/city/select-data/' + JSON.parse(form).city_id, 'select#kota', JSON.parse(form).city_id)
                $('#modalTitle').html('Edit Data Cabang')
                $('input[name="code"]').val(JSON.parse(form).code)
                $('input[name="name"]').val(JSON.parse(form).name)
                $('input[name="eos"]').val(JSON.parse(form).eos)
                $('input[name="eos_number"]').val(JSON.parse(form).eos_number)
                $('input[name="pic"]').val(JSON.parse(form).pic)
                $('input[name="pic_number"]').val(JSON.parse(form).pic_number)
                $('input[name="pic_ga"]').val(JSON.parse(form).pic_ga)
                $('input[name="pic_ga_number"]').val(JSON.parse(form).pic_ga_number)

                $('textarea[name="address"]').val(JSON.parse(form).address)
                mapboxSetCenter(JSON.parse(form).longitude, JSON.parse(form).latitude)
                $('#data-form-modal-table').attr('action', '/data-lokasi/branch/' + JSON.parse(form).id)
                $('#modal-form-centered').modal('show')

                // $('select#country').val(JSON.parse(form).countries_id)
                // $('select#country').trigger('change')
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
