@extends('layouts.template', [
    'pageTitle' => 'Send',
    'activeMenu' => 'send'
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Corporate</span>
			<span class="breadcrumb-item active">Send</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
	<div class="card-header header-elements-inline">
        <h5 class="card-title">List Send</h5>
        <div class="header-elements">
            <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
        </div>
	</div>

	<table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
		<thead>
			<tr>
				<th>#</th>
                <th class="text-center">Actions</th>
                <th>Title</th>
                <th>status</th>
                <th>Client phone</th>
                <th>Type</th>
                <th>Created At</th>
                <th>Updated At </th>
                <th>Created By</th>
                <th>Updated By </th>
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
                        <button type="button" class="btn btn-outline bg-success-600 text-success-600 btn-icon btn-sm rounded-round ml-2"
                            data-popup="tooltip" title="" data-placement="left" data-original-title="Delete" @click="checkAccountNumber(item.id,item.client_id,item.broadcast_type_id)">
                            <i class="far icon-truck"></i></button>
                    </div>
                </td>
                <td v-text="item.title"></td>
                <td v-if="item.status===0">Blm terkirim</td>
                <td v-else>Terkirim</td>

                <td v-if="item.broadcast_type_id===1" >-</td>
                <td v-else v-text="item.client_phone"></td>

              
                <td v-if="item.broadcast_type_id===1">Send to All</td>
                <td v-else v-text="'send to '+item.client_name"></td>
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
                    <div class="form-group">
                        <label for="broadcast_type">Payment Method</label>
                        <select id="broadcast_type" class="form-control select-search" data-placeholder="Pilih group..." onchange="app.select2Changed('broadcast_type', this.value)">
                            <option value=""></option>
                            <option v-for="item in dataType" :key="item.id" :value="item.id">@{{ item.type }}</option>
                        </select>
                        <span class="manual-error" v-if="form.errors.has('broadcast_type')">Pilih Merek type</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="client_id">Client</label>
                        <select id="client_id" class="form-control select-search" data-placeholder="Choice client name..." onchange="app.select2Changed('client_id', this.value)" :disabled="form.broadcast_type != 2">
                            <option value=""></option>
                            <option v-for="item in dataClient" :key="item.id" :value="item.id">@{{ item.client_phone+" | "+item.client_name }}</option>
                        </select>
                        <span class="manual-error" v-if="form.errors.has('client_id')">Choice client name</span>
                    </div>
                    <div class="form-group">
                        <label for="message_id">Message</label>
                        <select id="message_id" class="form-control select-search" data-placeholder="Choice client name..." onchange="app.select2Changed('message_id', this.value)">
                            <option value=""></option>
                            <option v-for="item in dataMessage" :key="item.id" :value="item.id">@{{ item.title }}</option>
                        </select>
                        <span class="manual-error" v-if="form.errors.has('message_id')">Choice client name</span>
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
                broadcast_type:0,
                client_id: "",
                message_id: 0,
            }),
            dataType: @json($dataType),
            dataClient: @json($dataClient),
            dataMessage: @json($dataMessage),
        },
        mounted() {
            $('.select-search').select2();
	        $('#datatable_basic').DataTable();
	        this.refreshDatatable();
        },
        
        methods: {
            select2Changed(field, value){
                if (field == 'broadcast_type') return this.form.broadcast_type = value
                if (field == 'client_id') return this.form.client_id = value
                if (field == 'message_id') return this.form.message_id = value
                
            },
            createModal(){
                this.editMode = false;
                this.form.reset();
                this.form.clear();
                console.log();
                $('#broadcast_type').val('').trigger('change')
                $('#client_id').val('').trigger('change')
                $('#message_id').val('').trigger('change')
                $('#modal_default').modal('show');
            },
            editModal(data){
                this.editMode = true;
                this.form.fill(data);
                this.form.clear();
                $('#broadcast_type').val(data.broadcast_type).trigger('change')
                $('#message_id').val(data.message_id).trigger('change')
                $('#client_id').val(data.client_id).trigger('change')
                if(data.client_id==0){
                    $('#client_id').val('All').trigger('change')
                }else{
                    $('#client_id').val(data.client_phone).trigger('change')
                }
                // console.log(data.client_phone);
                $('#modal_default').modal('show');
            },
            storeData(){
                l = laddaButton('.btn-ladda-submit')
                l.start();

                this.form.post("{{ route('send.store') }}")
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

                url = "{{ route('send.update', ':id') }}".replace(':id', this.form.id)
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
                        url = "{{ route('send.destroy', ':id') }}".replace(':id', id)
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
            
            checkAccountNumber(id,client_id,broadcast_type_id){
                // axios.post("{{ route('send.send') }}",{id :id,client_id:client_id,broadcast_type_id:broadcast_type_id})
                // .then(function (response) {
                //    // handle success
                //    console.log(response);
                //  })
                SendConfirmation.fire().then((result) => {
                    if (result.value) {
                axios.post("{{ route('send.send') }}",{id :id,client_id:client_id,broadcast_type_id:broadcast_type_id})
                    .then(response => {
                        // console.log(response.data.status);

                        basicFormSuccess(response.data.statusDesc)
                        this.refreshDatatable()
                        setTimeout(() => { $('#modal_default').modal('hide') }, 1500);
                    })
                    .catch(e => {
                        basicFormError(e)
                    })
                    }
                })
            },
            refreshDatatable(){
            	axios.get("{{ route('send.all') }}")
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