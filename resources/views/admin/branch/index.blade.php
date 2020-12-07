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
