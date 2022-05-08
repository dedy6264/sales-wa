@extends('layouts.template', [
    'pageTitle' => 'Client',
    'activeMenu' => 'productProvider'
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Biller</span>
			<span class="breadcrumb-item active">Product Provider</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
	<div class="card-header header-elements-inline">
        <h5 class="card-title">List Product Provider</h5>
        <div class="header-elements">
            <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
        </div>
	</div>

	<table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
		<thead>
			<tr>
				<th>#</th>
                <th class="text-center">Actions</th>
                <th>Product Code</th>
                <th>Product Provider Code</th>
                <th>Provider Name</th>
                <th>Product Name</th>
                <th>Provider Price</th>
                <th>Admin Fee</th>
                <th>Merchant Fee</th>
                <th>Provider Env Method</th>
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
                <td v-text="item.product_code"></td>
                <td v-text="item.product_provider_code"></td>
                <td v-text="item.product_name"></td>
                <td v-text="item.product_provider_name"></td>
                <td v-text="item.product_provider_price" align="right"></td>
                <td v-text="item.product_provider_admin_fee" align="right"></td>
                <td v-text="item.product_provider_merchant_fee" align="right"></td>
                <td v-text="item.product_provider_env_method"></td>
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
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_id">Product Name</label>
                            <select id="product_id" class="form-control select-search" data-placeholder="Choose Product name..." onchange="app.select2Changed('product_id', this.value)">
                                <option value=""></option>
                                <option v-for="item in productSelect" :key="item.id" :value="item.id">@{{ item.product_code }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('product_id')">Choose product name</span>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="provider_id">Provider Name</label>
                            <select id="provider_id" class="form-control select-search" data-placeholder="Choose Provider name..." onchange="app.select2Changed('provider_id', this.value)">
                                <option value=""></option>
                                <option v-for="item in providerSelect" :key="item.id" :value="item.id">@{{ item.provider_name }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('provider_id')">Choose provider name</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_provider_code">Product Provider Code</label>
                            <input id="product_provider_code" type="text" placeholder="Product Provider Code" class="form-control"
                                v-model="form.product_provider_code" :class="{ 'is-invalid': form.errors.has('product_provider_code') }">
                                <has-error :form="form" field="product_provider_code"></has-error>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_provider_name">Product Provider Name</label>
                            <input id="product_provider_name" type="text" placeholder="Product Provider Name" class="form-control"
                                v-model="form.product_provider_name" :class="{ 'is-invalid': form.errors.has('product_provider_name') }">
                                <has-error :form="form" field="product_provider_name"></has-error>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_provider_price">Price</label>
                            <input id="product_provider_price" type="number" placeholder="Price" class="form-control"
                                v-model="form.product_provider_price" :class="{ 'is-invalid': form.errors.has('product_provider_price') }">
                                <has-error :form="form" field="product_provider_price"></has-error>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_provider_admin_fee">Admin Fee</label>
                            <input id="product_provider_admin_fee" type="number" placeholder="Admin Fee" class="form-control"
                                v-model="form.product_provider_admin_fee" :class="{ 'is-invalid': form.errors.has('product_provider_admin_fee') }">
                                <has-error :form="form" field="product_provider_admin_fee"></has-error>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_provider_merchant_fee">Merchant Fee</label>
                            <input id="product_provider_merchant_fee" type="number" placeholder="Merchant Fee" class="form-control"
                                v-model="form.product_provider_merchant_fee" :class="{ 'is-invalid': form.errors.has('product_provider_merchant_fee') }">
                                <has-error :form="form" field="product_provider_merchant_fee"></has-error>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_provider_env_method">Provider Env Method</label>
                            <input id="product_provider_env_method" type="text" placeholder="Provider Env Method" class="form-control"
                                v-model="form.product_provider_env_method" :class="{ 'is-invalid': form.errors.has('product_provider_env_method') }">
                                <has-error :form="form" field="product_provider_env_method"></has-error>
                        </div>
                        <div class="row form-group col-md-12 col-sm-12 col-xs-12">
                            <span id="product_provider_env_method" class="col-sm-12 ml-2 px-4 border border-danger text-danger d-none" :class="{ 'd-block': form.errors.has('product_provider_index') }">Provider index has been created</span>
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
                product_id: '',
                provider_id: '',
                product_code: '',
                product_provider_code: '',
                product_provider_name: '',
                product_provider_price: '',
                product_provider_admin_fee: '',
                product_provider_merchant_fee: '',
                product_provider_env_method: '',
                product_provider_index:'',
            }),
            providerSelect: @json($providerSelect),
            productSelect: @json($productSelect)
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
                $('#product_id').val('').trigger('change')
                $('#provider_id').val('').trigger('change')
                $('#modal_default').modal('show');
            },
            editModal(data){
                this.editMode = true;
                this.form.fill(data);
                this.form.clear();
                $('#product_id').val(data.product_id).trigger('change')
                $('#provider_id').val(data.provider_id).trigger('change')
                $('#modal_default').modal('show');
            },
            select2Changed(field, value){
                this.form.product_provider_index = $('#product_id').find(':selected').val() + $('#provider_id').find(':selected').val();
                if (field == 'product_id') return this.form.product_id = value
                if (field == 'provider_id') return this.form.provider_id = value
            },
            storeData(){
                l = laddaButton('.btn-ladda-submit')
                l.start();

                this.form.post("{{ route('productprovider.store') }}")
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

                url = "{{ route('productprovider.update', ':id') }}".replace(':id', this.form.id)
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
                        url = "{{ route('productprovider.destroy', ':id') }}".replace(':id', id)
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
            	axios.get("{{ route('productprovider.all') }}")
                    .then(response => {
                        $('#datatable_basic').DataTable().destroy();
                        this.mainData = response.data
                        this.$nextTick(function() {
                            $('#datatable_basic').DataTable({
                                dom: '<"datatable-header "fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                                columnDefs: [ {
                                    targets: [6,7,8],
                                    render: $.fn.dataTable.render.number( '.', ',', 2)
                                } ],
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