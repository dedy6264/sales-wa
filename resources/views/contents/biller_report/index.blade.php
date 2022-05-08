@extends('layouts.template', [
    'pageTitle' => 'Transaction Report',
    'activeMenu' => 'reportTransaction',
    
])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
			<span class="breadcrumb-item">Biller</span>
			<span class="breadcrumb-item">Report</span>
			<span class="breadcrumb-item active">Transaction Report</span>
		</div>
	</div>
</div>
@endsection

@section('content')
<!-- Basic datatable -->
<div v-show="showMainCard">
    <div class="card">
        <div class="card-body">
            <form>
                <h6 class="font-weight-bold mb-2">Filter Data:</h6>
                <div class="row mb-2">
                    <div class="form-group col-sm-12 col-lg-2">
                        <label>Start Date:</label>
                        <div class="input-group">
                            <span class="input-group-prepend"><span class="input-group-text"><i class="icon-calendar22"></i></span></span>
                            <input id="startDate" type="text" class="form-control daterange-single" v-model="filterForm.startDate" v-daterangepicker>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-lg-2">
                        <label>End Date:</label>
                        <div class="input-group">
                            <span class="input-group-prepend"><span class="input-group-text"><i class="icon-calendar22"></i></span></span>
                            <input id="endDate" type="text" class="form-control daterange-single" v-model="filterForm.endDate" v-daterangepicker>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="status_code" :class="{ 'custom-is-invalid': filterForm.errors.has('status_code') }">Transaction Status</label>
                        <select id="status_code" class="form-control select-search" data-placeholder="Status..." data-minimum-results-for-search="Infinity"
                            v-model="filterForm.status_code" v-select2>
                            <option value="-1">All Status</option>
                            <option value="00">Success</option>
                            <option value="22">Pending</option>
                            <option value="33">Failed</option>
                        </select>
                        <has-error :form="filterForm" field="status_code"></has-error>
                    </div>     
                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="merchant_id" :class="{ 'custom-is-invalid': filterForm.errors.has('merchant_id') }">Merchant</label>
                        <select id="merchant_id" class="form-control select-search" data-placeholder="merchant..."
                            v-model="filterForm.merchant_id" v-select2 data-minimum-results-for-search="Infinity">
                            <option v-for="item in listMerchant" :key="item.id" :value="item.id">@{{ item.merchant_name }}</option>
                        </select>
                        <has-error :form="filterForm" field="merchant_id"></has-error>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-2 custom-margin-button">
                        <button type="submit" class="ml-auto btn bg-grey btn-block mt-auto btn-ladda btn-ladda-filter"  data-style="zoom-out"  @click="refreshDatatable()">Filter</button>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-2 custom-margin-button">
                        <button type="button" class="ml-auto btn bg-grey btn-block btn-ladda btn-ladda-export-excel"  data-style="zoom-out"  @click="exportExcel">Export Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- My messages -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xl-4">
            <div class="card card-body bg-grey has-bg-image">
                <div class="media mb-3">
                    <div class="mr-3 align-self-center">
                        <i class="icon-pulse2 icon-2x"></i>
                    </div>
                    <div class="media-body border-top-0 pt-0">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-uppercase font-size-xs">Product Price</div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0" v-text="currencyFormat(summaries.productPrice)"></h5>
                            </div>
                            <div class="col-6">
                                <div class="text-uppercase font-size-xs">Provider Price</div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0" v-text="currencyFormat(summaries.providerPrice)"></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <span>Total product price and total product provider price</span>
                <div class="progress bg-indigo mb-2" style="height: 0.125rem;">
                    <div class="progress-bar bg-white" style="width: 100%">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <div>
                    <span class="float-right">80%</span>
                    Persentase Margin
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xl-4">
            <div class="card card-body bg-grey has-bg-image">
                <div class="media mb-3">
                    <div class="mr-3 align-self-center">
                        <i class="icon-pulse2 icon-2x"></i>
                    </div>
                    <div class="media-body border-top-0 pt-0">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-uppercase font-size-xs">Merchant Fee</div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0" v-text="currencyFormat(summaries.merchantFee)"></h5>
                            </div>
                            <div class="col-6">
                                <div class="text-uppercase font-size-xs">Provider Fee</div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0" v-text="currencyFormat(summaries.providerMerchantFee)"></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <span>Total merchant fee and total provider fee</span>
                <div class="progress bg-indigo mb-2" style="height: 0.125rem;">
                    <div class="progress-bar bg-white" style="width: 100%">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <div>
                    <span class="float-right">80%</span>
                    Persentase Margin
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xl-4">
            <div class="card card-body bg-grey has-bg-image">
                <div class="media mb-3">
                    <div class="mr-3 align-self-center">
                        <i class="icon-pulse2 icon-2x"></i>
                    </div>
                    <div class="media-body border-top-0 pt-0">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-uppercase font-size-xs">Admin Fee</div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0" v-text="currencyFormat(summaries.adminFee)"></h5>
                            </div>
                            <div class="col-6">
                                <div class="text-uppercase font-size-xs">Provider Admin Fee</div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0" v-text="currencyFormat(summaries.providerAdminFee)"></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <span>Total admin fee and total provider admin fee</span>
                <div class="progress bg-indigo mb-2" style="height: 0.125rem;">
                    <div class="progress-bar bg-white" style="width: 100%">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <div>
                    <span class="float-right">80%</span>
                    Persentase Margin
                </div>
            </div>
        </div>
    </div>
    <!-- /my messages -->
    <!-- /my messages -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">List Biller Transaction Report</h5>
        </div>
        <table class="table table-hover table-striped table-xs text-nowrap" id="datatable_basic">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th>Transaction Number</th>
                    <th>Transaction Number Merchant</th>
                    <th>Payment Method</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Admin fee</th>
                    <th>Product Merchant fee</th>
                    <th>Product Provider Code</th>
                    <th>Product Provider Name</th>
                    <th>Product Provider Price</th>
                    <th>Product Provider Admin Fee</th>
                    <th>Product Provider Merchant Fee</th>
                    <th>Product Unit Name</th>
                    <th>Product Category Name</th>
                    <th>Product Type Name</th>
                    <th>Merchant Outlet Name</th>
                    <th>Merchant Name</th>
                    <th>Group Name</th>
                    <th>Region Name</th>
                    <th>Client Name</th>
                    <th>Provider Name</th>
                    <th>Transaction Number Provider</th>
                </tr>
            </thead>
        </table>
    </div>
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
            showMainCard : true,
            filterForm : new Form({
                startDate: moment().add(-30, 'day').format("YYYY-MM-DD"),
                endDate: moment().format("YYYY-MM-DD"),
                status_code:-1,
                merchant_id: @json($listMerchant)[0].id,
            }),
            summaries : new Form({
                productPrice: 0,
                adminFee: 0,
                merchantFee: 0,
                providerPrice: 0,
                providerAdminFee: 0,
                providerMerchantFee: 0,
            }),
            listMerchant: @json($listMerchant),
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
            currencyFormat(number){
                if(!number) number = 0;
                return $.fn.dataTable.render.number( '.', ',', 2).display(number);
            },
            exportExcel(){
                l = laddaButton('.btn-ladda-export-excel')
                l.start();
                setTimeout(() => { l.setProgress(0.5) }, 500);
                setTimeout(() => { l.stop(); l.remove() }, 1300);
                
                axios({
                    url: "{{ route('reportTransaction.export_excel') }}",
                    method: 'post',
                    responseType: 'blob', // important
                    data: {filter: this.filterForm},
                }).then((response) => {
                    toast('success', 'Data Exported')
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'Reporting Transaction Biller ('+this.filterForm.startDate +'-'+ this.filterForm.endDate+').xlsx'); 
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(e => {
                    basicFormError(e);
                })
                .finally(ok => {
                    setTimeout(() => { l.setProgress(0.5) }, 500);
                    setTimeout(() => { l.stop(); l.remove() }, 1300);
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
                        order: [ [2, 'desc'] ],
                        ajax: {
                            url: "{{ route('reportTransaction.all') }}",
                            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                            type: 'POST',
                            data: {filter: this.filterForm},
                            error: function (xhr, error, code) { swal.fire( 'Gagal!', xhr.responseJSON.message, 'error' ) }
                        },
                        columns: [
                            { data: 'DT_RowIndex', orderable: false, searchable: false },
                            { data: 'created_at', name: 'created_at'},
                            { data: 'created_by', name: 'created_by'},
                            { data: 'status_desc', name: 'status_desc'},
                            { data: 'transaction_number', name: 'transaction_number'},
                            { data: 'transaction_number_merchant', name: 'transaction_number_merchant'},
                            { data: 'payment_method_name', name: 'payment_method_name'},
                            { data: 'product_code', name: 'product_code'},
                            { data: 'product_name', name: 'product_name'},
                            { data: 'product_price', name: 'product_price', className:'text-right'},
                            { data: 'product_admin_fee', name: 'product_admin_fee', className:'text-right'},
                            { data: 'product_merchant_fee', name: 'product_merchant_fee', className:'text-right'},
                            { data: 'product_provider_code', name: 'product_provider_code'},
                            { data: 'product_provider_name', name: 'product_provider_name'},
                            { data: 'product_provider_price', name: 'product_provider_price', className:'text-right'},
                            { data: 'product_provider_admin_fee', name: 'product_provider_admin_fee', className:'text-right'},
                            { data: 'product_provider_merchant_fee', name: 'product_provider_merchant_fee', className:'text-right'},
                            { data: 'product_unit_name', name: 'product_unit_name'},
                            { data: 'product_category_name', name: 'product_category_name'},
                            { data: 'product_type_name', name: 'product_type_name'},
                            { data: 'merchant_outlet_name', name: 'merchant_outlet_name'},
                            { data: 'merchant_name', name: 'merchant_name'},
                            { data: 'group_name', name: 'group_name'},
                            { data: 'region_name', name: 'region_name'},
                            { data: 'client_name', name: 'client_name'},
                            { data: 'provider_name', name: 'provider_name'},
                            { data: 'transaction_number_provider', name: 'transaction_number_provider'},
                        ],
                        columnDefs: [{
                            targets: [6,7,8,11,12,13],
                            render: $.fn.dataTable.render.number( '.', ',', 2)
                        }],
                        drawCallback: function(callback){
                            $('[data-popup="tooltip"]').tooltip({trigger : 'hover'});
                            app.mainData = callback.json.data;
                        },
                        initComplete: function(response){
                            app.summaries.fill(response.json.payload)
                        }
                    });
                })
            },
        },
    })
</script>
@endpush