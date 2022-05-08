@extends('layouts.template', [
    'pageTitle' => 'Payment Method',
    'activeMenu' => 'paymentMethod'
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Corporate</span>
			<span class="breadcrumb-item active">Payment Method</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
	<div class="card-header header-elements-inline">
        <h5 class="card-title">Payment Method</h5>
        <div class="header-elements">
            <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
        </div>
	</div>

	<table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
		<thead>
			<tr>
				<th>#</th>
                <th class="text-center">Actions</th>
                <th>Method</th>
                <th>Description</th>
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
                        <div class="form-group col-md-12">
                            <label for="payment_method_name">Payment Method Name</label>
                            <input id="type" type="text" placeholder="Input Payment Method" class="form-control"
                                v-model="form.payment_method_name" :class="{ 'is-invalid': form.errors.has('payment_method_name') }">
                                <has-error :form="form" field="payment_method_name"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea id="description" rows="4" placeholder="Describe your method payment" class="form-control"
                                v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                                <has-error :form="form" field="description"></has-error>
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
                id: "",
                payment_method_name:"",
                description:"",
            }),
        },
        mounted() {
	        $('#datatable_basic').DataTable();
	        this.refreshDatatable();
        },
        methods: {
            createModal(){
                this.editMode = false;
                this.form.reset();
                this.form.clear();
                $('#modal_default').modal('show');
            },
            editModal(id){
                data = collect(this.mainData).firstWhere('id', id)
                this.editMode = true;
                this.form.fill(data)
                this.form.clear();
                $('#modal_default').modal('show');
            },
            
            storeData(){
                l = laddaButton('.btn-ladda-submit')
                l.start();

                this.form.post("{{ route('paymentMethod.store') }}")
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

                url = "{{ route('paymentMethod.update', ':id') }}".replace(':id', this.form.id)
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
                        url = "{{ route('paymentMethod.destroy', ':id') }}".replace(':id', id)
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
                        // order: [ [2, 'desc'] ],
                        ajax: {
                            url: "{{ route('paymentMethod.all') }}",
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
                            { data: 'payment_method_name'                , name: 'payment_method_name' },
                            { data: 'description'                , name: 'description' },
                            { data: 'created_at'                , name: 'created_at' },
                            { data: 'updated_at'                , name: 'updated_at' },
                            { data: 'created_by'                , name: 'created_by' },
                            { data: 'updated_by'                , name: 'updated_by' },
                            
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