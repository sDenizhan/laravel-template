@extends('themes.backend.default.layouts.app')

@section('pre-content')
    @php
        $data = [
            [
                'title' => __('Reports'),
                'url' => route('admin.reports.coordinators')
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
    <!-- Filtreler -->
    <div class="row mb-2">
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label">{{ __('Start Date') }}</label>
                <input type="date" class="form-control" id="start_date">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label">{{ __('End Date') }}</label>
                <input type="date" class="form-control" id="end_date">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">{{ __('Coordinator') }}</label>
                <select class="form-select" id="coordinator">
                    <option value="">{{ __('All Coordinators') }}</option>
                    <option value="1">John Doe</option>
                    <option value="2">Jane Smith</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-primary d-block" id="filter">{{ __('Filter') }}</button>
            </div>
        </div>
    </div>

    <!-- Depozito İstatistikleri -->
    <div class="row mb-2">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Total Deposits') }}</h5>
                    <h3 class="mt-3 mb-3">150</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Deposits (EUR)') }}</h5>
                    <h3 class="mt-3 mb-3">€25,000</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Deposits (USD)') }}</h5>
                    <h3 class="mt-3 mb-3">$30,000</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Deposits (GBP)') }}</h5>
                    <h3 class="mt-3 mb-3">£20,000</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Başvuru İstatistikleri -->
    <div class="row mb-2">
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
                    <h5 class="card-title">{{ __('Approved') }}</h5>
                    <h3 class="mt-3 mb-3">600</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Rejected') }}</h5>
                    <h3 class="mt-3 mb-3">200</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Pending') }}</h5>
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
                    <h4 class="card-title mb-4">{{ __('Monthly Application Status') }}</h4>
                    <div id="monthlyStatus" class="apex-charts"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ __('Response Time Analysis') }}</h4>
                    <div id="responseTime" class="apex-charts"></div>
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
            // Aylık Durum Grafiği
            var statusOptions = {
                series: [{
                    name: 'Total',
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 70, 75, 80]
                }, {
                    name: 'Approved',
                    data: [35, 41, 36, 26, 45, 48, 52, 53, 41, 55, 58, 62]
                }, {
                    name: 'Rejected',
                    data: [9, 14, 21, 30, 16, 10, 11, 7, 25, 15, 17, 18]
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

            var statusChart = new ApexCharts(document.querySelector("#monthlyStatus"), statusOptions);
            statusChart.render();

            // Cevap Süresi Analiz Grafiği
            var responseOptions = {
                series: [{
                    name: 'Applications',
                    type: 'column',
                    data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30, 25]
                }, {
                    name: 'Avg. Response Time (hours)',
                    type: 'line',
                    data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 38]
                }],
                chart: {
                    height: 350,
                    type: 'line',
                },
                stroke: {
                    width: [0, 4]
                },
                dataLabels: {
                    enabled: false,
                    enabledOnSeries: [1]
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                yaxis: [{
                    title: {
                        text: 'Applications',
                    },
                }, {
                    opposite: true,
                    title: {
                        text: 'Response Time (hours)'
                    }
                }]
            };

            var responseChart = new ApexCharts(document.querySelector("#responseTime"), responseOptions);
            responseChart.render();

            // Filtre Butonu Tıklama
            $('#filter').click(function() {
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();
                var coordinator = $('#coordinator').val();
                // Ajax ile verileri çekip grafikleri güncelleyebilirsiniz
            });
        });
    </script>
@endpush