@extends('layouts.template', [
    'pageTitle' => 'Merchant Outlet',
    'activeMenu' => 'merchantOutlet'
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Corporate</span>
			<span class="breadcrumb-item active">Merchant Outlet</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
	<div class="card-header header-elements-inline">
        <h5 class="card-title">List Merchant Outlet</h5>
        <div class="header-elements">
            <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
        </div>
	</div>

	<table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
		<thead>
			<tr>
				<th>#</th>
                <th class="text-center">Actions</th>
                <th>Merchant Name</th>
                <th>Merchant Outlet Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Created By</th>
                <th>Updated By</th>
			</tr>
		</thead>
	</table>
</div>
<!-- /basic datatable -->

<!-- Basic modal -->
<div id="modal_default" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" :class="editMode ? 'bg-info-600' : 'bg-indigo-400'">
                <h4 class="modal-title">@{{ (editMode ? 'Edit Data' : 'New Data') }}</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<form @submit.prevent="editMode ? updateData() : storeData()" @keydown="form.onKeydown($event)">
				<div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="merchant_id">Merchant Name</label>
                            <select id="merchant_id" class="form-control select-search-ajax" data-placeholder="Cari data berdasarkan nama Merchant..." onchange="app.select2Changed('merchant_id', this.value)"></select>
                            <span class="manual-error" v-if="form.errors.has('merchant_id')">Choose Merchant Name</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant_outlet_name">Merchant Outlet Name</label>
                            <input id="merchant_outlet_name" type="text" placeholder="Input Outlet Name" class="form-control"
                                v-model="form.merchant_outlet_name" :class="{ 'is-invalid': form.errors.has('merchant_outlet_name') }">
                                <has-error :form="form" field="merchant_outlet_name"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant_outlet_password">Merchant Outlet Password</label>
                            <input id="merchant_outlet_password" type="password" maxlengh='6' placeholder="Input Outlet Password" class="form-control"
                                v-model="form.merchant_outlet_password" :class="{ 'is-invalid': form.errors.has('merchant_outlet_password') }">
                                <has-error :form="form" field="merchant_outlet_password"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant_outlet_repassword">Re-type Password</label>
                            <input id="merchant_outlet_repassword" type="password" maxlengh='6' placeholder="Re-type your password" class="form-control"
                                v-model="form.merchant_outlet_repassword" :class="{ 'is-invalid': form.errors.has('merchant_outlet_repassword') }">
                                <has-error :form="form" field="merchant_outlet_repassword"></has-error>
                        </div>
                    </div>
				</div>

				<div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-ladda btn-ladda-submit" :class="editMode ? 'bg-info-600' : 'bg-indigo-400'">
						@{{ editMode ? 'Update' : 'Simpan' }}
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /basic modal -->
@endsection

@push('js')
<script src="{{ asset('template/global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
        	mainData: [],
            editMode : false,
            form : new Form({
                id: '',
                merchant_id: '',
                merchant_outlet_name: '',
                merchant_outlet_password: '',
            }),
        },
        mounted() {
            $(".select-search-ajax").select2({
                dropdownAutoWidth: true,
                width: '100%',
                ajax: {
                    url: "{{ route('ajaxSelect', 'merchant') }}",
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    dataType: 'json',
                    type: 'post',
                    quietMillis: 50,
                    data: function (term) {
                        return {
                            term: term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.merchant_name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 3,
            });

            $('.select-search').select2();
	        $('#datatable_basic').DataTable();
	        this.refreshDatatable();
        },
        watch: {
            form: {
                handler(val){
                    // detect select2 fail validation
                    var error = val.errors.errors;
                    select2Error(val = ('merchant_id' in error), indexSelect2 = 1)
                },
                deep: true,
            }
        },
        methods: {
            createModal(){
                this.editMode = false;
                this.form.reset();
                this.form.clear();

                $("#merchant_id").empty().append('<option value=""></option>').val('').trigger('change');

                $('#modal_default').modal('show');
            },
            editModal(id){
                data = collect(this.mainData).firstWhere('id', id)
                this.editMode = true;
                this.form.fill(data)
                this.form.clear();

                var text = data.merchant_name
                $("#merchant_id").empty()
                    .append('<option value="'+data.merchant_id+'">'+text+'</option>')
                    .val(data.merchant_id).trigger('change');
                
                $('#modal_default').modal('show');
            },
            select2Changed(field, value){
                if (field == 'merchant_id') return this.form.merchant_id = value
            },
            storeData(){
                l = laddaButton('.btn-ladda-submit')
                l.start();

                this.form.post("{{ route('merchantOutlet.store') }}")
                    .then(response => {
                        basicFormSuccess('Data berhasil disimpan')
                        this.refreshDatatable()
                        setTimeout(() => { $('#modal_default').modal('hide') }, 1500);
                    })
                    .catch(e => {
                        basicFormError(e)
                    })
                    .finally(ok => {
                        setTimeout(() => { l.setProgress(0.5) }, 500);
                        setTimeout(() => { l.stop(); l.remove() }, 1300);
                    })
            },
            updateData(){
                l = laddaButton('.btn-ladda-submit')
                l.start();

                url = "{{ route('merchantOutlet.update', ':id') }}".replace(':id', this.form.id)
                this.form.put(url)
                    .then(response => {
                        basicFormSuccess('Data berhasil diupdate')
                        this.refreshDatatable()
                        setTimeout(() => { $('#modal_default').modal('hide') }, 1500);
                    })
                    .catch(e => {
                        basicFormError(e)
                    })
                    .finally(ok => {
                        setTimeout(() => { l.setProgress(0.5) }, 500);
                        setTimeout(() => { l.stop(); l.remove() }, 1300);
                    })
            },
            deleteData(id){
                DeleteConfirmation.fire().then((result) => {
                    if (result.value) {
                        url = "{{ route('merchantOutlet.destroy', ':id') }}".replace(':id', id)
                        axios.delete(url)
                            .then(response => {
                                basicFormSuccess('Data berhasil dihapus')
                                this.refreshDatatable()
                            })
                            .catch(e => {
                                basicFormError(e)
                            })
                    }
                })
            },
            refreshDatatable(){
                $('#datatable_basic').DataTable().destroy();
                this.$nextTick(function() {
                    $('#datatable_basic').DataTable({
                        dom: '<"datatable-header "fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                        processing: true,
                        serverSide: true,
                        scrollX: true,
                        lengthMenu: [ 25, 50, 100 ],
                        ajax: {
                            url: "{{ route('merchantOutlet.all') }}",
                            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                            type: 'POST',
                            error: function (xhr, error, code) { swal.fire( 'Error!', xhr.responseJSON.message, 'error' ) }
                        },
                        columns: [
                            { data: 'DT_RowIndex', orderable: false, searchable: false },
                            { orderable: false, searchable: false,
                                render: function (data, type, row) {
                                    var html = '';
                                    html += '<button type="button" class="btn btn-outline bg-info-600 text-info-600 btn-icon btn-sm rounded-round mr-2"'+
                                            'data-popup="tooltip" title="" data-placement="left" data-original-title="Edit" onclick="app.editModal('+row.id+')">'+
                                            '<i class="fas fa-pencil-alt"></i></button>';
                                    html += '<button type="button" class="btn btn-outline bg-danger-600 text-danger-600 btn-icon btn-sm rounded-round ml-2"'+
                                            'data-popup="tooltip" title="" data-placement="left" data-original-title="Delete" onclick="app.deleteData('+row.id+')">'+
                                            '<i class="far fa-trash-alt"></i></button>';

                                    return html;
                                }
                            },
                            { data: 'merchant_name'              , name: 'merchant.merchant_name' },
                            { data: 'merchant_outlet_name'          , name: 'merchant_outlet.merchant_outlet_name' },
                            { data: 'created_at'          , name: 'merchant_outlet.created_at' },
                            { data: 'updated_at'          , name: 'merchant_outlet.updated_at' },
                            { data: 'created_by'          , name: 'merchant_outlet.created_by' },
                            { data: 'updated_by'          , name: 'merchant_outlet.updated_by' },
                        ],
                        drawCallback: function(callback){
                            $('[data-popup="tooltip"]').tooltip({trigger : 'hover'});
                            app.mainData = callback.json.data;
                        },
                        initComplete: function(data){
                            redrawTable();
                        }
                    });
                })
            },
        },
    })
</script>
@endpush