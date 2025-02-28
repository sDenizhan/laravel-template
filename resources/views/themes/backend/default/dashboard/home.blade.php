@extends('themes.backend.default.layouts.app')

@section('pre-content')
    <x-backend.breadcrumbs title="{{ __('Dashboard') }}" />
@endsection

@section('content')

    @if ( auth()->user()->hasRole('Super Admin') )

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card" id="tooltip-container">
                <div class="card-body">
                    <i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>
                    <h4 class="mt-0 font-16">Facebook / <small class="text-danger">Monthly</small></h4>
                    <h2 class="text-primary my-3 text-center">
                        <span data-plugin="counterup">900</span> <small class="text-danger"> / total number of inquiry</small>
                    </h2>
                    <p class="text-muted mb-0">This Month Approved: <span class="text-dark">500</span> <span class="float-end"><i class="fa fa-caret-down text-danger me-1"></i>16.67%</span></p>
                    <p class="text-muted mb-0">Last Month Inquiry: <span class="text-dark">700</span> <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>28.57%</span></p>
                    <p class="text-muted mb-0">Last Month Approved: <span class="text-dark">600</span> <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>10.25%</span></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card" id="tooltip-container1">
                <div class="card-body">
                    <i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>
                    <h4 class="mt-0 font-16">Google / <small class="text-danger">Monthly</small></h4>
                    <h2 class="text-primary my-3 text-center">
                        <span data-plugin="counterup">683</span> <small class="text-danger"> / total number of inquiry</small>
                    </h2>
                    <p class="text-muted mb-0">This Month Approved: <span class="text-dark">535</span> <span class="float-end"><i class="fa fa-caret-down text-danger me-1"></i>2.73%</span></p>
                    <p class="text-muted mb-0">Last Month Inquiry: <span class="text-dark">650</span> <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>5.08%</span></p>
                    <p class="text-muted mb-0">Last Month Approved: <span class="text-dark">550</span> <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>5.23%</span></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card" id="tooltip-container2">
                <div class="card-body">
                    <i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>
                    <h4 class="mt-0 font-16">Channel (site) / <small class="text-danger">Monthly</small></h4>
                    <h2 class="text-primary my-3 text-center">
                        <span data-plugin="counterup">534</span> <small class="text-danger"> / total number of inquiry</small>
                    </h2>

                    <p class="text-muted mb-0">This Month Approved: <span class="text-dark">485</span> <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>21.25%</span></p>
                    <p class="text-muted mb-0">Last Month Inquiry: <span class="text-dark">452</span> <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>18.14%</span></p>
                    <p class="text-muted mb-0">Last Month Approved: <span class="text-dark">400</span> <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>3.55%</span></p>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card" id="tooltip-container3">
                <div class="card-body">
                    <i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>
                    <h4 class="mt-0 font-16">Total / <small class="text-danger">Monthly</small></h4>
                    <h2 class="text-primary my-3 text-center">
                        <span data-plugin="counterup">2117</span> <small class="text-danger"> / total number of inquiry</small>
                    </h2>

                    <p class="text-muted mb-0">This Month Approved: <span class="text-dark">1520</span> <span class="float-end"><i class="fa fa-caret-down text-danger me-1"></i>1.94%</span></p>
                    <p class="text-muted mb-0">Last Month Inquiry: <span class="text-dark">1802</span> <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>17.48%</span></p>
                    <p class="text-muted mb-0">Last Month Approved: <span class="text-dark">1550</span> <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>8.25%</span></p>

                </div>
            </div>
        </div>
    </div> <!-- end row -->

    <div class="row">
        <div class="col-xl-6 col-md-12">
            <!-- Portlet card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">
                        <a href="javascript: void(0);" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                        <a data-bs-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                        <a href="javascript: void(0);" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                    </div>
                    <h4 class="header-title mb-0">{{ __('Number of Inquiries') }}</h4>

                    <div id="cardCollpase1" class="collapse show">
                        <div class="text-center pt-3">
                            <div id="chart1" data-colors="#00acc1,#f1556c"></div>
                        </div>
                    </div> <!-- collapsed end -->
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">
                        <a href="javascript: void(0);" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                        <a data-bs-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                        <a href="javascript: void(0);" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                    </div>
                    <h4 class="header-title mb-0">{{ __('Form Received - Planned / Monthly') }}</h4>

                    <div id="cardCollpase2" class="collapse show">
                        <div class="text-center pt-3">
                            <div id="chart2" data-colors="#00acc1"></div>
                        </div>
                    </div> <!-- collapsed end -->
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

    <div class="row">

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">
                        <a href="javascript: void(0);" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                        <a data-bs-toggle="collapse" href="#cardCollpase5" role="button" aria-expanded="false" aria-controls="cardCollpase5"><i class="mdi mdi-minus"></i></a>
                        <a href="javascript: void(0);" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                    </div>
                    <h4 class="header-title mb-0">{{ __('Latest 10 Inquiries') }}</h4>

                    <div id="cardCollpase5" class="collapse show">
                        <div class="table-responsive pt-3">
                            <table class="table table-hover table-centered mb-0">
                                <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Treatment</th>
                                    <th>Country</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($latest as $inquiry)
                                        <tr>
                                            <td>{{ join(' ', [$inquiry->name, $inquiry->surname]) }}</td>
                                            <td>{{ $inquiry->treatment->name }}</td>
                                            <td>{{ $inquiry->country }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">{{ __('No inquiries found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> <!-- end table responsive-->
                    </div> <!-- collapsed end -->
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">
                        <a href="javascript: void(0);" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                        <a data-bs-toggle="collapse" href="#cardCollpase5" role="button" aria-expanded="false" aria-controls="cardCollpase5"><i class="mdi mdi-minus"></i></a>
                        <a href="javascript: void(0);" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                    </div>
                    <h4 class="header-title mb-0">{{ __('Coordinator Inquiries') }}</h4>

                    <div id="cardCollpase5" class="collapse show">
                        <div class="table-responsive pt-3">
                            <table class="table table-hover table-centered mb-0">
                                <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Coordinator</th>
                                    <th>Treatment</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($userInquiries as $inquiry)
                                    <tr>
                                        <td>{{ join(' ', [$inquiry->name, $inquiry->surname]) }}</td>
                                        <td>{{ $inquiry->coordinator->name }}</td>
                                        <td>{{ $inquiry->treatment->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('No inquiries found') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div> <!-- end table responsive-->
                    </div> <!-- collapsed end -->
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->

        </div>
    @endif

@endsection

@push('scripts')
    <!-- apexcharts -->
    <script src="{{ asset('themes/backend/default/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="https://apexcharts.com/samples/assets/irregular-data-series.js"></script>
    <script src="https://apexcharts.com/samples/assets/ohlc.js"></script>

    <script>
        $(document).ready(function (){

            var options = {
                series: [
                    {
                        name: "Form Received",
                        data: [248, 219, 330, 346, 312, 322, 333]
                    },
                    {
                        name: "Planned",
                        data: [210, 190, 304, 318, 267, 293, 273]
                    }
                ],
                chart: {
                    height: 350,
                    type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#77B6EA', '#545454'],
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                markers: {
                    size: 1
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    title: {
                        text: 'Month'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Form Received / Planned'
                    },
                    min: 5,
                    max: 500
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    floating: true,
                    offsetY: -25,
                    offsetX: -5
                }
            };
            var chart = new ApexCharts(document.querySelector("#chart2"), options);
            chart.render();


            var options = {
                series: [{
                    name: "Inquiries",
                    data: [10, 41, 35, 51, 49, 62, 69, 91, 148, 100, 134, 200]
                }, {
                    name: "Approved",
                    data: [9, 23, 24, 32, 35, 41, 48, 59, 74, 91, 108, 130]
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                }
            };
            var chart = new ApexCharts(document.querySelector("#chart1"), options);
            chart.render();
        });
    </script>

@endpush
