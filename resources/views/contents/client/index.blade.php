@extends('layouts.template', [
    'pageTitle' => 'Client',
    'activeMenu' => 'client'
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Corporate</span>
			<span class="breadcrumb-item active">Client</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
	<div class="card-header header-elements-inline">
        <h5 class="card-title">List Client</h5>
        <div class="header-elements">
            <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
        </div>
        <div class="header-elements">
           <button type="button" @click="createImport" class="btn bg-indigo-800 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Import Data</button>
        </div>
	</div>

	<table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
		<thead>
			<tr>
				<th>#</th>
                <th class="text-center">Actions</th>
                <th>Client Name</th>
                <th>client_phone</th>
                <th>client_address</th>
                <th>status</th>
                <th>Created At</th>
                <th>Updated At </th> 
                <th>Created By</th>
                <th>Updated By</th>
			</tr>
		</thead>
		<tbody>
			<tr v-if="mainData" v-for="item, index in mainData" :key="index">
				<td v-text="index+1"></td>
                <td style="width: 16px;">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline bg-info-600 text-info-600 btn-icon btn-sm rounded-round ml-2"
                            data-popup="tooltip" title="" data-placement="left" data-original-title="Edit" @click="editModal(item)">
                            <i class="fas fa-pencil-alt"></i></button>
                        <button type="button" class="btn btn-outline bg-danger-600 text-danger-600 btn-icon btn-sm rounded-round ml-2"
                            data-popup="tooltip" title="" data-placement="left" data-original-title="Delete" @click="deleteData(item.id)">
                            <i class="far fa-trash-alt"></i></button>
                    </div>
                </td>
                <td v-text="item.client_name"></td>
                <td v-text="item.client_phone"></td>
                <td v-text="item.client_address"></td>
                <td v-text="item.status"></td>
                <td v-text="item.created_at"></td>
                <td v-text="item.updated_at"></td>
                <td v-text="item.created_by"></td>
                <td v-text="item.updated_by"></td>
			</tr>
		</tbody>
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
                        <label for="client_name">Client Name</label>
                        <input id="client_name" type="text" placeholder="Client Name" class="form-control"
                            v-model="form.client_name" :class="{ 'is-invalid': form.errors.has('client_name') }">
                            <has-error :form="form" field="client_name"></has-error>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="client_phone">Client Phone</label>
                        <input id="client_phone" type="number" placeholder="Client Name" class="form-control"
                            v-model="form.client_phone" :class="{ 'is-invalid': form.errors.has('client_phone') }">
                            <has-error :form="form" field="client_phone"></has-error>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="client_address">Client Address</label>
                        <input id="client_address" type="text" placeholder="Client Name" class="form-control"
                            v-model="form.client_address" :class="{ 'is-invalid': form.errors.has('client_address') }">
                            <has-error :form="form" field="client_address"></has-error>
                    </div>
                    </div>
				</div>

				<div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-ladda btn-ladda-submit" :class="editMode ? 'bg-info-600' : 'bg-indigo-400'">
						@{{ editMode ? 'Update' : 'Save' }}
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /basic modal -->
<!-- Basic modal import-->
<div id="modal_import" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" :class="editMode ? 'bg-info-600' : 'bg-indigo-400'">
                <h4 class="modal-title">@{{ (editMode ? 'Edit Data' : 'New Data') }}</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<form @submit.prevent="storeImport()" @keydown="formImport.onKeydown($event)">
				<div class="modal-body">
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label for="file">Client Name</label>
                        <input type="file" class="custom-file-input" id="objectfile" aria-describedby="inputGroupFileAddon01" accept=".xlsx" @change="fileChanged('objectfile', $event)">
                    </div>
                    </div>
				</div>

				<div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-ladda " :class="editMode ? 'bg-info-600' : 'bg-indigo-400'">
						@{{ editMode ? 'Update' : 'Save' }}
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /basic modal import -->
@endsection

@push('js')
<script>
    var app = new Vue({
        el: '#app',
        data: {
        	mainData: [],
            editMode : false,
            form : new Form({
                id: '',
                client_name: '',
                client_address:'',
                client_phone:'',
            }),
            formImport : new Form({
                file:'',
            }),
        },
        mounted() {

	        $('#datatable_basic').DataTable();
	        this.refreshDatatable();
        },
        
        methods: {
            fileChanged(item, e){ 
               
                const file = e.target.files[0]; 
                let reader = new FileReader(); 
                let that = this; 
                if (item == 'objectfile') { 
                    this.form.objectfile = file; 
                    } reader.readAsDataURL(file);
            },
            createImport(){
                this.editMode = false;
                this.formImport.reset();
                this.formImport.clear();
                $('#modal_import').modal('show');
            },
            createModal(){
                this.editMode = false;
                this.form.reset();
                this.form.clear();
                $('#modal_default').modal('show');
            },
            editModal(data){
                this.editMode = true;
                this.form.fill(data);
                this.form.clear();
                $('#modal_default').modal('show');
            },
            storeImport(){ 
                this.form.post("{{ route('client.import') }}",{ transformRequest: [function (data, headers) { 
                    return objectToFormData(data) 
                }], 
            })
                .then(response => { 
                    this.formImport = false; 
                    this.refreshData(); 
                    basicFormSuccess('Data berhasil disimpan'); 
                    }) 
                .catch(e => { 
                        console.log("errrorrrrr");
                        }) 
                },
            storeData(){
                l = laddaButton('.btn-ladda-submit')
                l.start();

                this.form.post("{{ route('client.store') }}")
                    .then(response => {
                        basicFormSuccess('Data telah disimpan')
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

                url = "{{ route('client.update', ':id') }}".replace(':id', this.form.id)
                this.form.put(url)
                    .then(response => {
                        basicFormSuccess('Data telah diupdate')
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
                        url = "{{ route('client.destroy', ':id') }}".replace(':id', id)
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
            	axios.get("{{ route('client.all') }}")
                    .then(response => {
                        $('#datatable_basic').DataTable().destroy();
                        this.mainData = response.data
                        this.$nextTick(function() {
                            $('#datatable_basic').DataTable({
                                dom: '<"datatable-header "fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                                drawCallback: function(){
                                    $('[data-popup="tooltip"]').tooltip({trigger : 'hover'});
                                }
                            });
                            redrawTable();
                        })
                    })
                    .catch(e => {
                        basicFormError(e)
                    })
            }
        },
    })
</script>
@endpush