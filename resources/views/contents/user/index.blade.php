@extends('layouts.template', ['activeMenu' => 'user'])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">User Management</span>
			<span class="breadcrumb-item active">User</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
	<div class="card-header header-elements-inline">
        <h5 class="card-title">List User</h5>
        <div class="header-elements">
            <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
        </div>
	</div>

	<table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
		<thead>
			<tr>
				<th>#</th>
                <th class="text-center" align="center">Actions</th>
                <th>Username</th>
                <th>Email</th>
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
                <td v-text="item.username"></td>
                <td v-text="item.email"></td>
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
                <h4 class="modal-title">@{{ (editMode ? 'Edit ' : 'New ')+toastMessage }}</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<form @submit.prevent="editMode ? updateData() : storeData()" @keydown="form.onKeydown($event)">
				<div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="text" placeholder="Input Nama User" class="form-control"
                            v-model="form.username" :class="{ 'is-invalid': form.errors.has('username') }">
                            <has-error :form="form" field="username"></has-error>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" placeholder="Input Email" class="form-control"
                            v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="password">Password</label>
                            <input id="password" type="password" placeholder="Input Password" class="form-control"
                                v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation">Re-Type Password</label>
                            <input id="password_confirmation" type="password" placeholder="Input Ulang Password" class="form-control"
                                v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                        </div>
                    </div>
				</div>

				<div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" class="btn" :class="editMode ? 'bg-info-600' : 'bg-indigo-400'">
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
                username: '',
                email: '',
                password: '',
                password_confirmation: '',
            }),
            toastMessage: 'User',
        },
        mounted() {
            $('.select-search').select2();
            $('.form-control-uniform').uniform();
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
            editModal(data){
                this.editMode = true;
                this.form.fill(data)
                this.form.clear();
                $('#modal_default').modal('show');
            },
            vueChanged(){
                this.form.iddepartementoutlet = $('#outlet').val()
            },
            storeData(){
                this.form.post("{{ route('user.store') }}")
                    .then(response => {
                        $('#modal_default').modal('hide')
                        basicFormSuccess(this.toastMessage, 'created')
                        this.refreshDatatable()
                    })
                    .catch(e => {
                        basicFormError(e)
                    })
            },
            updateData(){
                url = "{{ route('user.update', ':id') }}".replace(':id', this.form.id)
                this.form.put(url)
                    .then(response => {
                        $('#modal_default').modal('hide');
                        basicFormSuccess(this.toastMessage, 'updated')
                        this.refreshDatatable()
                    })
                    .catch(e => {
                        basicFormError(e)
                    })
            },
            deleteData(id){
                DeleteConfirmation.fire().then((result) => {
                    if (result.value) {
                        url = "{{ route('user.destroy', ':id') }}".replace(':id', id)
                        this.form.delete(url)
                            .then(response => {
                                basicFormSuccess(this.toastMessage, 'deleted')
                                this.refreshDatatable()
                            })
                            .catch(e => {
                                basicFormError(e)
                            })
                    }
                })
            },
            refreshDatatable(){
            	axios.get("{{ route('user.all') }}")
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