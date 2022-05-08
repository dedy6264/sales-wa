@extends('layouts.template', [
    'pageTitle' => 'Segment',
    'activeMenu' => 'segment'
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Corporate</span>
			<span class="breadcrumb-item active">Segment</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
	<div class="card-header header-elements-inline">
        <h5 class="card-title">Segmentation</h5>
        <div class="header-elements">
            <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
        </div>
	</div>

	<table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
		<thead>
			<tr>
				<th>#</th>
                <th class="text-center">Actions</th>
                <th>Segment Desciption</th>
                <th>Created At</th>
                <th>Updated At </th>
                <th>Created By</th>
                <th>Updated By </th>
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
                            <label for="segment_name">Segment Name</label>
                            <input id="type" type="text" placeholder="Input Segment Name" class="form-control"
                                v-model="form.segment_name" :class="{ 'is-invalid': form.errors.has('segment_name') }">
                                <has-error :form="form" field="segment_name"></has-error>
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
                segment_name: "",
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

                this.form.post("{{ route('segment.store') }}")
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

                url = "{{ route('segment.update', ':id') }}".replace(':id', this.form.id)
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
                        url = "{{ route('segment.destroy', ':id') }}".replace(':id', id)
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
            copyData(id){
                CopyConfirmation.fire().then((result) => {
                    if (result.value) {
                        url = "{{ route('segment.copy', ':id') }}".replace(':id', id)
                        axios.post(url)
                            .then(response => {
                                basicFormSuccess('Data berhasil dicopy')
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
                            url: "{{ route('segment.all') }}",
                            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                            type: 'POST',
                            error: function (xhr, error, code) { swal.fire( 'Error!', xhr.responseJSON.message, 'error' ) }
                        },
                        columns: [
                            { data: 'DT_RowIndex', orderable: false, searchable: false },
                            { searchable: false,
                                render: function (data, type, row) {
                                    var html = '';
                                    html += '<button type="button" class="btn btn-outline bg-info-600 text-info-600 btn-icon btn-sm rounded-round mr-2"'+
                                            'data-popup="tooltip" title="" data-placement="left" data-original-title="Edit" onclick="app.editModal('+row.id+')">'+
                                            '<i class="fas fa-pencil-alt"></i></button>';
                                    html += '<button type="button" class="btn btn-outline bg-danger-600 text-danger-600 btn-icon btn-sm rounded-round ml-2"'+
                                            'data-popup="tooltip" title="" data-placement="left" data-original-title="Delete" onclick="app.deleteData('+row.id+')">'+
                                            '<i class="far fa-trash-alt"></i></button>';
                                    html += '<button type="button" class="btn btn-outline bg-success-600 text-success-600 btn-icon btn-sm rounded-round ml-2"'+
                                            'data-popup="tooltip" title="" data-placement="left" data-original-title="DUplicate Segment" onclick="app.copyData('+row.id+')">'+
                                    '<i class="far icon-paste2"></i></button>';

                                    return html;
                                },className:'text-center'
                            },
                            { data: 'segment_name'                , name: 'segment.segment_name' },
                            { data: 'created_at'                , name: 'segment.created_at' },
                            { data: 'updated_at'                , name: 'segment.updated_at' },
                            { data: 'created_by'                , name: 'segment.created_by' },
                            { data: 'updated_by'                , name: 'segment.updated_by' },
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