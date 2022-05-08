@extends('layouts.template', [
    'pageTitle' => 'Client',
    'activeMenu' => 'billerProduct'
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
                <th>Product Type Name</th>
                <th>Product Category Name</th>
                <th>Unit Name</th>
                <th>Code</th>
                <th>Name</th>
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
                <td v-text="item.product_type_name"></td>
                <td v-text="item.product_category_name"></td>
                <td v-text="item.product_unit_name"></td>
                <td v-text="item.product_code"></td>
                <td v-text="item.product_name"></td>
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
                            <label for="product_type_id">Type</label>
                            <select id="product_type_id" class="form-control select-search" data-placeholder="Choose Product type..." onchange="app.select2Changed('product_type_id', this.value)">
                                <option value=""></option>
                                <option v-for="item in typesSelect" :key="item.id" :value="item.id">@{{ item.product_type_name }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('product_type_id')">Choose product type</span>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_category_id">Category</label>
                            <select id="product_category_id" class="form-control select-search" data-placeholder="Choose Product category..." onchange="app.select2Changed('product_category_id', this.value)">
                                <option value=""></option>
                                <option v-for="item in categorySelect" :key="item.id" :value="item.id">@{{ item.product_category_name }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('product_category_id')">Choose product category</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_unit_name">Unit Name</label>
                            <input id="product_unit_name" type="text" placeholder="Unit Name" class="form-control"
                                v-model="form.product_unit_name" :class="{ 'is-invalid': form.errors.has('product_unit_name') }">
                                <has-error :form="form" field="product_unit_name"></has-error>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_code">Product Code</label>
                            <input id="product_code" type="text" placeholder="Product Code" class="form-control"
                                v-model="form.product_code" :class="{ 'is-invalid': form.errors.has('product_code') }">
                                <has-error :form="form" field="product_code"></has-error>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input id="product_name" type="text" placeholder="Product Name" class="form-control"
                            v-model="form.product_name" :class="{ 'is-invalid': form.errors.has('product_name') }">
                            <has-error :form="form" field="product_name"></has-error>
                    </div>
                    <!-- <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_price">Price</label>
                            <input id="product_price" type="number" placeholder="Price" class="form-control"
                                v-model="form.product_price" :class="{ 'is-invalid': form.errors.has('product_price') }">
                                <has-error :form="form" field="product_price"></has-error>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_admin_fee">Admin Fee</label>
                            <input id="product_admin_fee" type="number" placeholder="Admin Fee" class="form-control"
                                v-model="form.product_admin_fee" :class="{ 'is-invalid': form.errors.has('product_admin_fee') }">
                                <has-error :form="form" field="product_admin_fee"></has-error>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_merchant_fee">Merchant Fee</label>
                            <input id="product_merchant_fee" type="number" placeholder="Merchant Fee" class="form-control"
                                v-model="form.product_merchant_fee" :class="{ 'is-invalid': form.errors.has('product_merchant_fee') }">
                                <has-error :form="form" field="product_merchant_fee"></has-error>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_role_assign_provider">Provider</label>
                            <select id="product_role_assign_provider" class="form-control select-search" data-placeholder="Choose Provider Name..." onchange="app.select2Changed('product_role_assign_provider', this.value)">
                                <option value="-">Multi Provider</option>
                                <option v-for="item in providerSelect" :key="item.id" :value="item.id">@{{ item.provider_name }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('product_role_assign_provider')">Choose Provider Name</span>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_role_multi_provider">Multi Provider</label>
                            <select id="product_role_multi_provider" class="form-control select-search" data-placeholder="Choose Multi Provider..." onchange="app.select2Changed('product_role_multi_provider', this.value)">
                                <option value=""></option>
                                <option value="Y">Y</option>
                                <option value="N">N</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('product_role_multi_provider')">Choose Multi Provider</span>
                        </div>
                    </div> -->
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
                product_type_id: '',
                product_category_id: '',
                product_unit_name:'',
                product_code: '',
                product_name: '',
                
            }),
            typesSelect: @json($typesSelect),
            categorySelect: @json($categorySelect),
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
                $('#product_type_id').val('').trigger('change')
                $('#product_category_id').val('').trigger('change')
                $('#modal_default').modal('show');
            },
            editModal(data){
                this.editMode = true;
                this.form.fill(data);
                this.form.clear();
                $('#product_type_id').val(data.product_type_id).trigger('change')
                $('#product_category_id').val(data.product_category_id).trigger('change')
                
                $('#modal_default').modal('show');
            },
            select2Changed(field, value){
                if (field == 'product_type_id') return this.form.product_type_id = value
                if (field == 'product_category_id') return this.form.product_category_id = value
            },
            storeData(){
                l = laddaButton('.btn-ladda-submit')
                l.start();

                this.form.post("{{ route('product.store') }}")
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

                url = "{{ route('product.update', ':id') }}".replace(':id', this.form.id)
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
                        url = "{{ route('product.destroy', ':id') }}".replace(':id', id)
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
            	axios.get("{{ route('product.all') }}")
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