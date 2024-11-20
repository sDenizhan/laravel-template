@extends('themes.backend.default.layouts.app')

@section('pre-content')
    <x-backend.breadcrumbs title="{{ __('Dashboard') }}" />
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-sm bg-blue rounded">
                                <i class="fe-aperture avatar-title font-22 text-white"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">1500</span></h3>
                                <p class="text-muted mb-1 text-truncate">{{ __('Total Inquiries') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->

        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-sm bg-success rounded">
                                <i class="fe-cpu avatar-title font-22 text-white"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">1340</span></h3>
                                <p class="text-muted mb-1 text-truncate">{{ __('Total Form Received Inquiries') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->

        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-sm bg-warning rounded">
                                <i class="fe-bar-chart-2 avatar-title font-22 text-white"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">130</span></h3>
                                <p class="text-muted mb-1 text-truncate">{{ __('Total Inquiries For Today') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->

    </div>
    <!-- end row -->

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
                    <h4 class="header-title mb-0">{{ __('Inquiries & Form Received') }}</h4>

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
                    <h4 class="header-title mb-0">Top Selling Products</h4>

                    <div id="cardCollpase5" class="collapse show">
                        <div class="table-responsive pt-3">
                            <table class="table table-hover table-centered mb-0">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>ASOS Ridley High Waist</td>
                                    <td>$79.49</td>
                                    <td>82</td>
                                    <td>$6,518.18</td>
                                </tr>
                                <tr>
                                    <td>Marco Lightweight Shirt</td>
                                    <td>$128.50</td>
                                    <td>37</td>
                                    <td>$4,754.50</td>
                                </tr>
                                <tr>
                                    <td>Half Sleeve Shirt</td>
                                    <td>$39.99</td>
                                    <td>64</td>
                                    <td>$2,559.36</td>
                                </tr>
                                <tr>
                                    <td>Lightweight Jacket</td>
                                    <td>$20.00</td>
                                    <td>184</td>
                                    <td>$3,680.00</td>
                                </tr>
                                <tr>
                                    <td>Marco Shoes</td>
                                    <td>$28.49</td>
                                    <td>69</td>
                                    <td>$1,965.81</td>
                                </tr>
                                <tr>
                                    <td>ASOS Ridley High Waist</td>
                                    <td>$79.49</td>
                                    <td>82</td>
                                    <td>$6,518.18</td>
                                </tr>
                                <tr>
                                    <td>Half Sleeve Shirt</td>
                                    <td>$39.99</td>
                                    <td>64</td>
                                    <td>$2,559.36</td>
                                </tr>
                                <tr>
                                    <td>Lightweight Jacket</td>
                                    <td>$20.00</td>
                                    <td>184</td>
                                    <td>$3,680.00</td>
                                </tr>
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
                    <h4 class="header-title mb-0">Top Selling Products</h4>

                    <div id="cardCollpase5" class="collapse show">
                        <div class="table-responsive pt-3">
                            <table class="table table-hover table-centered mb-0">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>ASOS Ridley High Waist</td>
                                    <td>$79.49</td>
                                    <td>82</td>
                                    <td>$6,518.18</td>
                                </tr>
                                <tr>
                                    <td>Marco Lightweight Shirt</td>
                                    <td>$128.50</td>
                                    <td>37</td>
                                    <td>$4,754.50</td>
                                </tr>
                                <tr>
                                    <td>Half Sleeve Shirt</td>
                                    <td>$39.99</td>
                                    <td>64</td>
                                    <td>$2,559.36</td>
                                </tr>
                                <tr>
                                    <td>Lightweight Jacket</td>
                                    <td>$20.00</td>
                                    <td>184</td>
                                    <td>$3,680.00</td>
                                </tr>
                                <tr>
                                    <td>Marco Shoes</td>
                                    <td>$28.49</td>
                                    <td>69</td>
                                    <td>$1,965.81</td>
                                </tr>
                                <tr>
                                    <td>ASOS Ridley High Waist</td>
                                    <td>$79.49</td>
                                    <td>82</td>
                                    <td>$6,518.18</td>
                                </tr>
                                <tr>
                                    <td>Half Sleeve Shirt</td>
                                    <td>$39.99</td>
                                    <td>64</td>
                                    <td>$2,559.36</td>
                                </tr>
                                <tr>
                                    <td>Lightweight Jacket</td>
                                    <td>$20.00</td>
                                    <td>184</td>
                                    <td>$3,680.00</td>
                                </tr>
                                </tbody>
                            </table>
                        </div> <!-- end table responsive-->
                    </div> <!-- collapsed end -->
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->

    </div>
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
                        name: "Inquiries",
                        data: [28, 29, 33, 36, 32, 32, 33]
                    },
                    {
                        name: "Form Received",
                        data: [12, 11, 14, 18, 17, 13, 13]
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
                        text: 'Inquiries'
                    },
                    min: 5,
                    max: 40
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
