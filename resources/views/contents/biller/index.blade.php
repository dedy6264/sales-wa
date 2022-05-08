@extends('layouts.template', [
    'pageTitle' => 'Biller',
    'activeMenu' => 'biller',
    
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Biller</span>
			<span class="breadcrumb-item active">Biller</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div class="card">
	<div class="card-header header-elements-inline">
        <h5 class="card-title">List Biller</h5>
	</div>

    <div class="card-body">
        <form @submit.prevent="refreshDatatable()" @keydown="form.onKeydown($event)">
            <hr>
            <h6 class="font-weight-bold mb-2">Filter Data:</h6>

            <div class="row mb-2">
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label>Start Date:</label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input id="startDate" type="text" class="form-control daterange-single" :value="filterForm.startDate">
                    </div>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label>End Date:</label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input id="endDate" type="text" class="form-control daterange-single" :value="filterForm.endDate">
                    </div>
                </div>
            </div>

			<div class="row">
                <div class="form-group col-md-4 col-sm-6 col-xs-12 d-flex">
                    <button type="submit" class="ml-auto btn bg-grey btn-block mt-auto">Filter</button>
                </div>
			</div>
        </form>
    </div>

	<table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
		<thead>
			<tr>
                <th>#</th>
                <th>Account Transaction Number</th>
                <th>Account Transaction Number Reff</th>
                <th>Account Transaction Desc</th>
                <th>Created At</th>
                <th>Updated At </th>
                <th>Created By</th>
                <th>Updated By </th>
			</tr>
		</thead>
	</table>
</div>
<!-- /basic datatable -->
@endsection

@push('js')
<script src="{{ asset('template/global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
        	mainData: [],
            mainDataDetail: [],
            editMode : false,
            filterForm : new Form({
                startDate: moment().add(-30, 'day').format("YYYY-MM-DD"),
                endDate: moment().format("YYYY-MM-DD"),
            }),
        },
        mounted() {
            $('.daterange-single').daterangepicker({ 
                timePicker: false,
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('.select-search').select2();
	        $('#datatable_basic').DataTable();
	        this.refreshDatatable();
        },
        
        methods: {
            select2Changed(field, value){
                if (field == 'merchant_id') return this.form.merchant_id = value
            },
            transactionDetail(id){
                axios.post("{{ route('accountTransaction.transaction_detail') }}", { id:id })
                    .then(response => {
                        $('#datatable_detail').DataTable().destroy();
                        this.mainDataDetail = response.data
                        this.$nextTick(function() {
                            $('#datatable_detail').DataTable({
                                dom: '<"datatable-header "Bl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                                drawCallback: function(){
                                    $('[data-popup="tooltip"]').tooltip({trigger : 'hover'});
                                }
                            });
                            redrawTable();
                        })
                    })
                    .catch(e => {
                        basicFormError(e);
                    })
                $('#modal_detail').modal('show');
            },
            refreshDatatable(){
                this.filterForm.startDate = $('#startDate').val();
                this.filterForm.endDate = $('#endDate').val();
                this.filterForm.post("{{ route('accountTransaction.check_daterange') }}")
                    .then(response => {
                        toast('success', 'Filter applied')
                        $('#datatable_basic').DataTable().destroy();
                        this.$nextTick(function() {
                            $('#datatable_basic').DataTable({
                                dom: '<"datatable-header "l><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                                processing: true,
                                serverSide: true,
                                order: [ [4, 'desc'] ], // order by tanggal
                                ajax: {
                                    url: "{{ route('accountTransaction.all') }}",
                                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                                    type: 'POST',
                                    data: {filter: this.filterForm},
                                    error: function (xhr, error, code) { swal.fire( 'Gagal!', xhr.responseJSON.message, 'error' ) }
                                },
                                columns: [
                                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                                    { data: 'account_transaction_number', name: 'account_transaction_number' },
                                    { data: 'account_transaction_number_reff', name: 'account_transaction_number_reff' },
                                    { data: 'account_transaction_desc', name: 'account_transaction_desc' },
                                    { data: 'created_at', name: 'created_at' },
                                    { data: 'updated_at', name: 'updated_at' },
                                    { data: 'created_by', name: 'created_by' },
                                    { data: 'updated_by', name: 'updated_by' },
                                ],
                                drawCallback: function(){
                                    $('[data-popup="tooltip"]').tooltip({trigger : 'hover'});
                                },
                                initComplete: function(data){
                                    // app.updateTableSuccess(data.json.payload);
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