@extends('layouts.template', [
    'pageTitle' => 'Biller',
    'activeMenu' => 'billerProviderEnv'
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Biller</span>
			<span class="breadcrumb-item active">Biller Provider Env</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
	<div class="card-header header-elements-inline">
        <h5 class="card-title">List Biller Provider Env</h5>
        <div class="header-elements">
            <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
        </div>
	</div>

	<table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
		<thead>
			<tr>
				<th>#</th>
                <th class="text-center">Actions</th>
                <th>Provider Payment Env Code</th>
                <th>Provider Payment Env Name</th>
                <th>Value Id</th>
                <th>Value Support</th>
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
                    </div>
                </td>
                <td v-text="item.provider_payment_env_code"></td>
                <td v-text="item.provider_payment_env_name"></td>
                <td v-text="item.provider_payment_env_value_id"></td>
                <td v-text="item.provider_payment_env_value_support"></td>
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
                        <label for="provider_id">Provider Name</label>
                        <select id="provider_id" class="form-control select-search" data-placeholder="Choose Provider name..." onchange="app.select2Changed('provider_id', this.value)">
                            <option value=""></option>
                            <option v-for="item in providerSelect" :key="item.id" :value="item.id">@{{ item.provider_name }}</option>
                        </select>
                        <span class="manual-error" v-if="form.errors.has('provider_id')">Choose product name</span>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="provider_payment_env_code">Provider Env Code</label>
                            <input id="provider_payment_env_code" type="text" placeholder="Provider Env Code" class="form-control"
                                v-model="form.provider_payment_env_code" :class="{ 'is-invalid': form.errors.has('provider_payment_env_code') }">
                                <has-error :form="form" field="provider_payment_env_code"></has-error>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="provider_payment_env_name">Provider Env Name</label>
                            <input id="provider_payment_env_name" type="text" placeholder="Provider Env Name" class="form-control"
                                v-model="form.provider_payment_env_name" :class="{ 'is-invalid': form.errors.has('provider_payment_env_name') }">
                                <has-error :form="form" field="provider_payment_env_name"></has-error>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="provider_payment_env_value_id">Value ID</label>
                            <input id="provider_payment_env_value_id" type="text" placeholder="Value ID" class="form-control"
                                v-model="form.provider_payment_env_value_id" :class="{ 'is-invalid': form.errors.has('provider_payment_env_value_id') }">
                                <has-error :form="form" field="provider_payment_env_value_id"></has-error>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="provider_payment_env_value_support">Value Support</label>
                            <input id="provider_payment_env_value_support" type="text" placeholder="Value Support" class="form-control"
                                v-model="form.provider_payment_env_value_support" :class="{ 'is-invalid': form.errors.has('provider_payment_env_value_support') }">
                                <has-error :form="form" field="provider_payment_env_value_support"></has-error>
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
                provider_id: '',
                provider_payment_env_code:'',
                provider_payment_env_name:'',
                provider_payment_env_value_id:'',
                provider_payment_env_value_support:'',
                product_provider_env_method:'',
            }),
            providerSelect: @json($providerSelect),
        },
        mounted() {
            $('.select-search').select2();
	        $('#datatable_basic').DataTable();
	        this.refreshDatatable();
        },
        
        methods: {
           
            createModal(){
                this.editMode = false;
                this.form.reset();
                this.form.clear();
                $('#provider_id').val('').trigger('change')
                $('#modal_default').modal('show');
            },
            editModal(data){
                this.editMode = true;
                this.form.fill(data);
                this.form.clear();
                $('#provider_id').val(data.provider_id).trigger('change')
                $('#modal_default').modal('show');
            },
            select2Changed(field, value){
                if (field == 'provider_id') return this.form.provider_id = value
            },
            storeData(){
                l = laddaButton('.btn-ladda-submit')
                l.start();

                this.form.post("{{ route('billerproviderenv.store') }}")
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

                url = "{{ route('billerproviderenv.update', ':id') }}".replace(':id', this.form.id)
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
                        url = "{{ route('billerproviderenv.destroy', ':id') }}".replace(':id', id)
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
            	axios.get("{{ route('billerproviderenv.all') }}")
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