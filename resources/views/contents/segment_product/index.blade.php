@extends('layouts.template', [
    'pageTitle' => 'Segment Product',
    'activeMenu' => 'segmentProduct'
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Corporate</span>
			<span class="breadcrumb-item active">Segment Product</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
    <div class="card-body">
        <form>
            <h6 class="font-weight-bold mb-2">Filter Data:</h6>
            <div class="row mb-2">
                <div class="form-group col-sm-12 col-lg-6">
                    <label for="segment_id_filter" :class="{ 'custom-is-invalid': filterForm.errors.has('segment_id_filter') }">Segment</label>
                    <select id="segment_id_filter" class="form-control select-search" data-placeholder="merchant..."
                        v-model="filterForm.segment_id_filter" v-select2 data-minimum-results-for-search="Infinity">
                        <option v-for="item in listSegment" :key="item.id" :value="item.id">@{{ item.segment_name }}</option>
                    </select>
                    <has-error :form="filterForm" field="segment_id_filter"></has-error>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 custom-margin-button">
                    <button type="submit" class="ml-auto btn bg-grey btn-block mt-auto btn-ladda btn-ladda-filter"  data-style="zoom-out"  @click="refreshDatatable()">Filter</button>
                </div>
                
            </div>
        </form>
    </div>
</div>
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
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Admin Fee</th>
                <th>Product Merchant Fee</th>
                <th>Product Role Assign Provider</th>
                <th>Product Role Multi Provider</th>
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
                        
                        <div class="form-group col-md-6">
                            <label for="segment_id">Segment</label>
                            <select id="segment_id" class="form-control select-search" data-placeholder="Pilih group..." onchange="app.select2Changed('segment_id', this.value)">
                                <option value=""></option>
                                <option v-for="item in listSegment" :key="item.id" :value="item.id">@{{ item.segment_name }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('segment_id')">Pilih Merek Merchant</span>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="product_price">Product Price</label>
                            <input id="type" type="number" placeholder="Input Segment Name" class="form-control"
                                v-model="form.product_price" :class="{ 'is-invalid': form.errors.has('product_price') }">
                                <has-error :form="form" field="product_price"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_id">Product</label>
                            <select id="product_id" class="form-control select-search" data-placeholder="Pilih group..." onchange="app.select2Changed('product_id', this.value)">
                                <option value=""></option>
                                <option v-for="item in product" :key="item.id" :value="item.id">@{{ item.product_name }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('product_id')">Pilih Merek Merchant</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_admin_fee">Product Admin Fee</label>
                            <input id="type" type="number" placeholder="Input Segment Name" class="form-control"
                                v-model="form.product_admin_fee" :class="{ 'is-invalid': form.errors.has('product_admin_fee') }">
                                <has-error :form="form" field="product_admin_fee"></has-error>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="product_role_assign_provider">Provider</label>
                            <select id="product_role_assign_provider" class="form-control select-search" data-placeholder="Choose Provider Name..." onchange="app.select2Changed('product_role_assign_provider', this.value)">
                                <option value="-">Multi Provider</option>
                                <option v-for="item in provider" :key="item.id" :value="item.id">@{{ item.provider_name }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('product_role_assign_provider')">Choose Provider Name</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_merchant_fee">Merchant Fee</label>
                            <input id="type" type="number" placeholder="Input Segment Name" class="form-control"
                                v-model="form.product_merchant_fee" :class="{ 'is-invalid': form.errors.has('product_merchant_fee') }">
                                <has-error :form="form" field="product_merchant_fee"></has-error>
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
            filterForm : new Form({
                segment_id_filter: @json($listSegment)[0].id,
            }),
            form : new Form({
                id: "",
                segment_id:"",
                product_id:"",
                product_price:"",
                product_admin_fee:"",
                product_merchant_fee:"",
                product_role_assign_provider:"",
                product_role_multi_provider:"",

            }),
            listSegment: @json($listSegment),
            product: @json($product),
            provider: @json($provider),
        },
        mounted() {
	        $('#datatable_basic').DataTable();
            $('.select-search').select2();
	        this.refreshDatatable();
        },
        watch: {
            form: {
                handler(val){
                    // detect select2 fail validation
                    var error = val.errors.errors;
                    select2Error(val = ('segment_id' in error), indexSelect2 = 1)
                    select2Error(val = ('product_id' in error), indexSelect2 = 2)
                    select2Error(val = ('product_role_assign_provider' in error), indexSelect2 = 3)
                    select2Error(val = ('product_role_multi_provider' in error), indexSelect2 = 3)
                },
                deep: true,
            }
        },
        methods: {
            createModal(){
                this.editMode = false;
                this.form.reset();
                this.form.clear();
                $('#segment_id').val('').trigger('change')
                $('#product_id').val('').trigger('change')
                $('#product_role_assign_provider').val('').trigger('change')
                $('#product_role_multi_provider').val('Y').trigger('change')
                $('#modal_default').modal('show');
            },
            editModal(id){
                data = collect(this.mainData).firstWhere('id', id)
                this.editMode = true;
                this.form.fill(data)
                this.form.clear();
                $('#segment_id').val(data.segment_id).trigger('change')
                $('#product_id').val(data.product_id).trigger('change')
                $('#product_role_multi_provider').val(data.product_role_multi_provider).trigger('change')
                if(data.product_role_assign_provider == "") {
                    $('#product_role_assign_provider').val("-").trigger('change')
                } else {
                    $('#product_role_assign_provider').val(data.product_role_assign_provider).trigger('change')
                }
                $('#modal_default').modal('show');
                console.log(data.segment_id);
            },
            select2Changed(field, value){
                if (field == 'segment_id') return this.form.segment_id = value
                if (field == 'product_id') return this.form.product_id = value
                if (field == 'product_role_assign_provider') return this.form.product_role_assign_provider = value
                if (field == 'product_role_multi_provider') return this.form.product_role_multi_provider = value
            },
            storeData(){
                l = laddaButton('.btn-ladda-submit')
                l.start();

                this.form.post("{{ route('segmentProduct.store') }}")
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

                url = "{{ route('segmentProduct.update', ':id') }}".replace(':id', this.form.id)
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
                        url = "{{ route('segmentProduct.destroy', ':id') }}".replace(':id', id)
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
                    l = laddaButton('.btn-ladda-filter')
                    l.start();
                    setTimeout(() => { l.setProgress(0.5) }, 500);
                    setTimeout(() => { l.stop(); l.remove() }, 1300);
                    $('#datatable_basic').DataTable({
                        dom: '<"datatable-header "fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                        processing: true,
                        serverSide: true,
                        scrollX: true,
                        lengthMenu: [ 25, 50, 100 ],
                        ajax: {
                            url: "{{ route('segmentProduct.all') }}",
                            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                            type: 'POST',
                            data: {filter: this.filterForm},
                            error: function (xhr, error, code) { swal.fire( 'Error!', xhr.responseJSON.message, 'error' ) }
                        },
                        columnDefs: [{
                            targets: [4,5,6],
                            render: $.fn.dataTable.render.number( '.', ',', 2)
                        }],
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
                            { data: 'segment_name'                  , name: 'segment.segment_name' },
                            { data: 'product_name'                  , name: 'product.product_name' },
                            { data: 'product_price'                 , name: 'segment_product.product_price', className:'text-right' },
                            { data: 'product_admin_fee'             , name: 'segment_product.product_admin_fee' , className:'text-right'},
                            { data: 'product_merchant_fee'          , name: 'segment_product.product_merchant_fee', className:'text-right' },
                            { data: 'provider_name'  , name: 'provider.provider_name' },
                            { data: 'product_role_multi_provider'   , name: 'segment_product.product_role_multi_provider' },
                            { data: 'created_at'                    , name: 'segment_product.created_at' },
                            { data: 'updated_at'                    , name: 'segment_product.updated_at' },
                            { data: 'created_by'                    , name: 'segment_product.created_by' },
                            { data: 'updated_by'                    , name: 'segment_product.updated_by' },
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