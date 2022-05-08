@extends('layouts.template', [
    'pageTitle' => 'Merchant',
    'activeMenu' => 'merchant'
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Corporate</span>
			<span class="breadcrumb-item active">Merchant</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
	<div class="card-header header-elements-inline">
        <h5 class="card-title">List Merchant</h5>
        <div class="header-elements">
            <button type="button" @click="createModal" class="btn bg-indigo-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus-circle2"></i></b> Add Data</button>
        </div>
	</div>

	<table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
		<thead>
			<tr>
				<th>#</th>
                <th class="text-center">Actions</th>
                <th>Group Id</th>
                <th>Village Id</th>
                <th>Merchant Name</th>
                <th>Merchant NIK</th>
                <th>Merchant Address</th>
                <th>Merchant Telp</th>
                <th>Merchant Email</th>
                <th>Payment Method</th>
                <th>Account Number</th>
                <th>Segment</th>
                <th>Merchant Date of Birth</th>
                <th>Created At</th>
                <th>Deleted At</th>
                <th>Created By</th>
                <th>Deleted By</th>
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
                            <label for="village_id">Kota/Kab - Kecamatan - Desa</label>
                            <select id="village_id" class="form-control select-search-ajax" data-placeholder="Cari data berdasarkan nama desa..." onchange="app.select2Changed('village_id', this.value)"></select>
                            <span class="manual-error" v-if="form.errors.has('village_id')">Pilih Desa</span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="group_id">Group</label>
                            <select id="group_id" class="form-control select-search" data-placeholder="Pilih group..." onchange="app.select2Changed('group_id', this.value)">
                                <option value=""></option>
                                <option v-for="item in group" :key="item.id" :value="item.id">@{{ item.group_name }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('group_id')">Pilih Merek Merchant</span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="merchant_name">Merchant Name</label>
                            <input id="type" type="text" placeholder="Input Merchant Name" class="form-control"
                                v-model="form.merchant_name" :class="{ 'is-invalid': form.errors.has('merchant_name') }">
                                <has-error :form="form" field="merchant_name"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant_nik">Merchant NIK</label>
                            <input id="merchant_nik" type="text" placeholder="Input Merchan NIK" class="form-control"
                                v-model="form.merchant_nik" :class="{ 'is-invalid': form.errors.has('merchant_nik') }">
                                <has-error :form="form" field="merchant_nik"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant_telp">Merchant Telp</label>
                            <input id="merchant_telp" type="text" placeholder="Input Telephone" class="form-control"
                                v-model="form.merchant_telp" :class="{ 'is-invalid': form.errors.has('merchant_telp') }">
                                <has-error :form="form" field="merchant_telp"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant_email">Merchant Email</label>
                            <input id="merchant_email" type="text" placeholder="Input Email" class="form-control"
                                v-model="form.merchant_email" :class="{ 'is-invalid': form.errors.has('merchant_email') }">
                                <has-error :form="form" field="merchant_email"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant_date_of_birth">Merchant Date of Birth</label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                </span>
                                <input id="merchant_date_of_birth" type="text" class="form-control daterange-single" data-parent="modal" onchange="app.select2Changed('merchant_date_of_birth', this.value)">
                            </div>
                            <has-error :form="form" field="merchant_date_of_birth"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="segment_id">Segment</label>
                            <select id="segment_id" class="form-control select-search" data-placeholder="Pilih group..." onchange="app.select2Changed('segment_id', this.value)">
                                <option value=""></option>
                                <option v-for="item in segment" :key="item.id" :value="item.id">@{{ item.segment_name }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('segment_id')">Pilih Merek Merchant</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="payment_method_id">Payment Method</label>
                            <select id="payment_method_id" class="form-control select-search" data-placeholder="Pilih group..." onchange="app.select2Changed('payment_method_id', this.value)">
                                <option value=""></option>
                                <option v-for="item in payment" :key="item.id" :value="item.id">@{{ item.payment_method_name }}</option>
                            </select>
                            <span class="manual-error" v-if="form.errors.has('payment_method_id')">Pilih Merek Merchant</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="merchant_account_number" >Check Account</label>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Account Number" class="form-control"
                                v-model="form.merchant_account_number" :class="{ 'is-invalid': form.errors.has('merchant_account_number') }">
                                    <has-error :form="form" field="merchant_account_number"></has-error>
                                    <span class="input-group-append">
										<button class="btn btn-light" type="button">Check</button>
									</span>
							</div>
						</div>
                        <div class="form-group col-md-12">
                            <label for="merchant_address">Merchant Address</label>
                            <textarea id="merchant_address" rows="4" placeholder="Input Address" class="form-control"
                                v-model="form.merchant_address" :class="{ 'is-invalid': form.errors.has('merchant_address') }"></textarea>
                                <has-error :form="form" field="merchant_address"></has-error>
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
                id: 0,
                group_id: 0,
                village_id: "",
                merchant_name: "",
                merchant_nik: "",
                merchant_address: "",
                merchant_telp: "",
                merchant_email: "",
                payment_method_id: 0,
                segment_id: 0,
                merchant_account_number:"",
                merchant_date_of_birth: moment().format("YYYY-MM-DD"),
            }),
            group: @json($group),
            payment: @json($payment),
            segment: @json($segment),
        },
        mounted() {
            $(".select-search-ajax").select2({
                dropdownAutoWidth: true,
                width: '100%',
                ajax: {
                    url: "{{ route('ajaxSelect', 'village') }}",
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
                                    text: item.uraiankota+' - '+item.uraiankecamatan+' - '+item.uraiandesa,
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
                    select2Error(val = ('group_id' in error), indexSelect2 = 1)
                    select2Error(val = ('village_id' in error), indexSelect2 = 2)
                    select2Error(val = ('segment_id' in error), indexSelect2 = 3)
                    select2Error(val = ('payment_method_id' in error), indexSelect2 = 4)
                },
                deep: true,
            }
        },
        methods: {
            createModal(){
                this.editMode = false;
                this.form.reset();
                this.form.clear();
                $('#group_id').val('').trigger('change')
                $('#segment_id').val('').trigger('change')
                $('#payment_method_id').val('1').trigger('change')

                $("#village_id").empty().append('<option value=""></option>').val('').trigger('change');

                $('#merchant_date_of_birth').daterangepicker({
                    timePicker: false,
                    singleDatePicker: true,
                    locale: { format: 'YYYY-MM-DD' },
                    startDate: new Date(),
                });

                $('#modal_default').modal('show');
            },
            editModal(id){
                data = collect(this.mainData).firstWhere('id', id)
                this.editMode = true;
                this.form.fill(data)
                this.form.clear();
                $('#group_id').val(data.group_id).trigger('change')
                $('#segment_id').val(data.segment_id).trigger('change')
                $('#payment_method_id').val(data.payment_method_id).trigger('change')

                var text = data.uraiankota+' - '+data.uraiankecamatan+' - '+data.uraiandesa
                $("#village_id").empty()
                    .append('<option value="'+data.village_id+'">'+text+'</option>')
                    .val(data.village_id).trigger('change');

                $('#merchant_date_of_birth').daterangepicker({
                    timePicker: false,
                    singleDatePicker: true,
                    locale: { format: 'YYYY-MM-DD' },
                    startDate: data.merchant_date_of_birth,
                });

                $('#modal_default').modal('show');
            },
            select2Changed(field, value){
                if (field == 'group_id') return this.form.group_id = value
                if (field == 'village_id') return this.form.village_id = value
                if (field == 'merchant_date_of_birth') return this.form.merchant_date_of_birth = value
                if (field == 'segment_id') return this.form.segment_id = value
                if (field == 'payment_method_id') return this.form.payment_method_id = value
            },
            storeData(){
                l = laddaButton('.btn-ladda-submit')
                l.start();

                this.form.post("{{ route('merchant.store') }}")
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

                url = "{{ route('merchant.update', ':id') }}".replace(':id', this.form.id)
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
                        url = "{{ route('merchant.destroy', ':id') }}".replace(':id', id)
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
                            url: "{{ route('merchant.all') }}",
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
                            { data: 'group_name'                , name: 'group.group_name' },
                            { data: '', name: 'indonesia_villages.name', render: function (data, type, row) {
                                    return row.uraiankota+' - '+row.uraiankecamatan+' - '+row.uraiandesa;
                                }
                            },
                            { data: 'merchant_name'             , name: 'merchant.merchant_name' },
                            { data: 'merchant_nik'              , name: 'merchant.merchant_nik' },
                            { data: 'merchant_address'          , name: 'merchant.merchant_address' },
                            { data: 'merchant_telp'             , name: 'merchant.merchant_telp' },
                            { data: 'merchant_email'            , name: 'merchant.merchant_email' },
                            { data: 'payment_method_name'    , name: 'payment_method.payment_method_name' },
                            { data: 'merchant_account_number'    , name: 'merchant.merchant_account_number' },
                            { data: 'segment_name'    , name: 'segment.segment_name' },
                            { data: 'merchant_date_of_birth'    , name: 'merchant.merchant_date_of_birth' },
                            { data: 'created_at'    , name: 'merchant.created_at' },
                            { data: 'updated_at'    , name: 'merchant.updated_at' },
                            { data: 'created_by'    , name: 'merchant.created_by' },
                            { data: 'updated_by'    , name: 'merchant.updated_by' },
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