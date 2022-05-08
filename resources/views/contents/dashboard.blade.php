@extends('layouts.template', ['activeMenu' => 'dashboard'])

@section('breadcrumb')
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
	<div class="d-flex">
		<div class="breadcrumb">
			<span class="breadcrumb-item active"><i class="icon-home2 mr-2"></i> Dashboard</span>
		</div>

		<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
	</div>
</div>
@endsection

@section('content')
<!-- My messages -->
<div class="row">
	<div class="col-md-12 col-sm-12 col-xl-4">
		<div class="card card-body bg-grey has-bg-image">
			<div class="media mb-3">
				<div class="mr-3 align-self-center">
					<i class="icon-stats-dots icon-2x"></i>
				</div>
				<div class="media-body border-top-0 pt-0">
					<div class="row">
						<div class="col-6">
							<div class="text-uppercase font-size-xs">Product Price</div>
							<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">{{ 'Rp.'.number_format($summaries['tot_product_price'],'2',',','.') }}</h5>
						</div>
						<div class="col-6">
							<div class="text-uppercase font-size-xs">Provider Price</div>
							<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">{{ 'Rp.'.number_format($summaries['tot_product_provider_price'],'2',',','.') }}</h5>
						</div>
					</div>
				</div>
			</div>
			<span>Total this year ({{date('Y')}})</span>
			<div class="progress bg-indigo mb-2" style="height: 0.125rem;">
				<div class="progress-bar bg-white" style="width: 100%">
					<span class="sr-only"></span>
				</div>
			</div>
			<div>
				<span class="float-right"></span>
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
							<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">{{ 'Rp.'.number_format($summaries['tot_product_merchant_fee'],'2',',','.') }}</h5>
						</div>
						<div class="col-6">
							<div class="text-uppercase font-size-xs">Provider Fee</div>
							<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">{{ 'Rp.'.number_format($summaries['tot_product_provider_merchant_fee'],'2',',','.') }}</h5>
						</div>
					</div>
				</div>
			</div>
			<span>Total this year ({{date('Y')}})</span>
			<div class="progress bg-indigo mb-2" style="height: 0.125rem;">
				<div class="progress-bar bg-white" style="width: 100%">
					<span class="sr-only"></span>
				</div>
			</div>
			<div>
				<span class="float-right"></span>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xl-4">
		<div class="card card-body bg-grey has-bg-image">
			<div class="media mb-3">
				<div class="mr-3 align-self-center">
					<i class="icon-equalizer4 icon-2x"></i>
				</div>
				<div class="media-body border-top-0 pt-0">
					<div class="row">
						<div class="col-6">
							<div class="text-uppercase font-size-xs">Admin Fee</div>
							<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">{{ 'Rp.'.number_format($summaries['tot_product_admin_fee'],'2',',','.') }}</h5>
						</div>
						<div class="col-6">
							<div class="text-uppercase font-size-xs">Provider Admin Fee</div>
							<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">{{ 'Rp.'.number_format($summaries['tot_product_provider_admin_fee'],'2',',','.') }}</h5>
						</div>
					</div>
				</div>
			</div>
			<span>Total this year ({{date('Y')}})</span>
			<div class="progress bg-indigo mb-2" style="height: 0.125rem;">
				<div class="progress-bar bg-white" style="width: 100%">
					<span class="sr-only"></span>
				</div>
			</div>
			<div>
				<span class="float-right"></span>
			</div>
		</div>
	</div>
</div>
<!-- /my messages -->

<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Total revenue biller this year ({{ date('Y') }})</h5>
		<div class="header-elements">
			<div class="list-icons">
				<a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item" data-action="reload"></a>
				<a class="list-icons-item" data-action="remove"></a>
			</div>
		</div>
	</div>

	<div class="card-body">
		<div class="chart-container">
			<div class="chart has-fixed-height" id="pie_rose_labels" style="user-select: none; position: relative;" _echarts_instance_="ec_1597023129117"><div style="position: relative; overflow: hidden; width: 476px; height: 400px; padding: 0px; margin: 0px; border-width: 0px; cursor: pointer;"><canvas style="position: absolute; left: 0px; top: 0px; width: 476px; height: 400px; user-select: none; padding: 0px; margin: 0px; border-width: 0px;" data-zr-dom-id="zr_0" width="476" height="400"></canvas></div><div></div></div>
		</div>
	</div>
</div>
@endsection

@push('js')

<script src="{{ asset('template/global_assets/js/plugins/visualization/echarts/echarts.min.js') }}"></script>
<script>
var EchartsPiesDonuts = function() {

// Pie and donut charts
	var _piesDonutsExamples = function() {
		if (typeof echarts == 'undefined') {
			console.warn('Warning - echarts.min.js is not loaded.');
			return;
		}

		// Define elements
		var pie_rose_labels_element = document.getElementById('pie_rose_labels');

		// Rose with labels
		if (pie_rose_labels_element) {

			// Initialize chart
			var pie_rose_labels = echarts.init(pie_rose_labels_element);


			//
			// Chart config
			//

			// Options
			pie_rose_labels.setOption({

				// Colors
				color: [
					'#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
					'#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
					'#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
					'#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
				],

				// Global text styles
				textStyle: {
					fontFamily: 'Roboto, Arial, Verdana, sans-serif',
					fontSize: 13
				},

				// Add title
				title: {
					text: 'Pie Chart Biller Revenue '+{{ date('Y')}},
					subtext: 'Powered by API Biller',
					left: 'center',
					textStyle: {
						fontSize: 17,
						fontWeight: 500
					},
					subtextStyle: {
						fontSize: 12
					}
				},

				// Add tooltip
				tooltip: {
					trigger: 'item',
					backgroundColor: 'rgba(0,0,0,0.75)',
					padding: [10, 15],
					textStyle: {
						fontSize: 13,
						fontFamily: 'Roboto, sans-serif'
					},
					formatter: "{a} <br/>{b}: Rp.{c} ({d}%)",
				},

				// Add legend
				legend: {
					orient: 'vertical',
					top: 'center',
					left: 0,
					data: @json($dataBulanArray),
					itemHeight: 8,
					itemWidth: 8
				},
				// Vertical axis
				// Add series
				series: [
					{
						name: 'Total Nett',
						type: 'pie',
						radius: ['15%', '80%'],
						center: ['50%', '57.5%'],
						roseType: 'area',
						itemStyle: {
							normal: {
								borderWidth: 1,
								borderColor: '#fff'
							}
						},
						data: @json($datapiefix)
					}
				]
			});
		}
		//
		// Resize charts
		//

		// Resize function
		var triggerChartResize = function() {
			pie_rose_labels_element && pie_rose_labels.resize();
		};

		// On sidebar width change
		$(document).on('click', '.sidebar-control', function() {
			setTimeout(function () {
				triggerChartResize();
			}, 0);
		});

		// On window resize
		var resizeCharts;
		window.onresize = function () {
			clearTimeout(resizeCharts);
			resizeCharts = setTimeout(function () {
				triggerChartResize();
			}, 200);
		};
	};


	return {
		init: function() {
			_piesDonutsExamples();
		}
	}
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
	EchartsPiesDonuts.init();
});

</script>

<script type="text/javascript">
         var app = new Vue({
        el: '#app',})
</script>
@endpush