@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Reports'),
                'url' => route('admin.reports.applications')
            ],
            [
                'title' => __('Show'),
                'url' => ''
            ]
        ];
    @endphp
    <x-backend.breadcrumbs title="{{ __('Reports') }}" :links="$data" />
@endsection

@section('content')
    <!-- Tarih Filtresi -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">{{ __('Start Date') }}</label>
                <input type="date" class="form-control" id="start_date">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">{{ __('End Date') }}</label>
                <input type="date" class="form-control" id="end_date">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-primary d-block" id="filter">{{ __('Filter') }}</button>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Total Applications') }}</h5>
                    <h3 class="mt-3 mb-3">1000</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Approved Applications') }}</h5>
                    <h3 class="mt-3 mb-3">600</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Cancelled Applications') }}</h5>
                    <h3 class="mt-3 mb-3">200</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Pending Applications') }}</h5>
                    <h3 class="mt-3 mb-3">200</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafikler -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ __('Monthly Applications') }}</h4>
                    <div id="monthlyApplications" class="apex-charts"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ __('Applications by Source') }}</h4>
                    <div id="applicationsBySource" class="apex-charts"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('themes/backend/default/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="https://apexcharts.com/samples/assets/irregular-data-series.js"></script>
    <script src="https://apexcharts.com/samples/assets/ohlc.js"></script>

    <script>
        $(document).ready(function() {
            // Aylık Başvurular Grafiği
            var monthlyOptions = {
                series: [{
                    name: 'Applications',
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 70, 75, 80]
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                }
            };

            var monthlyChart = new ApexCharts(document.querySelector("#monthlyApplications"), monthlyOptions);
            monthlyChart.render();

            // Kaynaklara Göre Başvurular Grafiği
            var sourceOptions = {
                series: [{
                    name: 'Google',
                    data: [44, 55, 41, 67, 22, 43, 21, 33, 45, 31, 87, 65]
                }, {
                    name: 'Facebook',
                    data: [13, 23, 20, 8, 13, 27, 33, 12, 67, 22, 43, 21]
                }, {
                    name: 'Web',
                    data: [11, 17, 15, 15, 21, 14, 15, 13, 21, 14, 15, 13]
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                }
            };

            var sourceChart = new ApexCharts(document.querySelector("#applicationsBySource"), sourceOptions);
            sourceChart.render();

            // Filtre Butonu Tıklama
            $('#filter').click(function() {
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();
                // Ajax ile verileri çekip grafikleri güncelleyebilirsiniz
            });
        });
    </script>
@endpush 