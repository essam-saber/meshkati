{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    <div class="row">
        <div class="col-lg-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Profit Analysis - {{$currentYear}}</h3>
                    </div>
                </div>
                <div class="card-body" >
                    <!--begin::Chart-->
                    <div id="chart_3" class="d-flex justify-content-center"></div>
                    <!--end::Chart-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <div class="col-lg-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b ">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Sales & Comparison  {{ $currentYear }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin::Chart-->
                    <div id="sales-comparison"></div>
                    <!--end::Chart-->
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Sales Analysis - {{$currentYear}}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin::Chart-->
                    <div id="sales-analysis" class="d-flex justify-content-center"></div>
                    <!--end::Chart-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <div class="col-lg-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Total Sales Target - {{$currentYear}}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin::Chart-->
                    <div id="total-sales-target"></div>
                    <!--end::Chart-->
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
    <div class="row">


    @endsection

{{-- Scripts Section --}}
@section('scripts')
{{--    <script src="{{ asset('js/pages/features/charts/apexcharts.js') }}" type="text/javascript"></script>--}}

            <script>

                const primary = '#6993FF';
                const success = '#1BC5BD';
                const info = '#8950FC';
                const warning = '#FFA800';
                const danger = '#F64E60';

                //area chart
                let _demo2 = function () {
                    const apexChart = "#sales-comparison";
                    var options = {
                        series: [{
                            name: 'total actual sales',
                            data: {!! json_encode($currentYearSales->pluck('total')) !!}
                        }, {
                            name: 'total budget sales',
                            data: {!! json_encode($budgets->pluck('total')) !!}
                        }],
                        chart: {
                            height: 350,
                            type: 'area'
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        xaxis: {
                            type: 'text',
                            categories:{!! json_encode($months) !!}
                        },
                        tooltip: {
                            // x: {
                            //     format: 'dd/MM/yy HH:mm'
                            // },
                        },
                        colors: [primary, success]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();
                }
                let _sales_analysis = function () {
                    const apexChart = "#sales-analysis";
                    var options = {
                        series:[ {!! json_encode($currentYearSales->sum('cash')) !!}, {!! json_encode($currentYearSales->sum('credit')) !!}, {!! json_encode($currentYearSales->sum('total')) !!},{!! json_encode($currentYearSales->sum('returns')) !!},{!! json_encode($currentYearSales->sum('net')) !!}],
                        chart: {
                            width: 380,
                            type: 'pie',
                        },
                        labels: ['Cash', 'Credit', 'Total','Returns','Net Sales'],
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }],
                        colors: [primary, success, warning, danger, info]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();
                }
                let _demo3 = function () {
                    const apexChart = "#chart_3";
                    var options = {
                        series: [{
                            name: 'Net',
                            data: {!! json_encode($currentYearSales->pluck('net')) !!}
                        }, {
                            name: 'Gross Profit',
                            data:{!! json_encode($currentYearSales->pluck('net_profit')) !!}
                        }, {
                            name: 'Net Profit',
                            data: {!! json_encode($currentYearSales->pluck('g_profit')) !!}
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
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                        },
                        yaxis: {
                            title: {
                                text: 'RAS (thousands)'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "RAS " + val + " thousands"
                                }
                            }
                        },
                        colors: [primary, success, warning]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();
                }
                let _sales_target = function () {
                    const apexChart = "#total-sales-target";
                    var options = {
                        series: [{!! json_encode($currentYearSales->sum('total')) !!}],
                        chart: {
                            height: 255,
                            type: 'radialBar',
                        },
                        plotOptions: {
                            radialBar: {
                                dataLabels: {
                                    name: {
                                        fontSize: '22px',
                                    },
                                    value: {
                                        fontSize: '16px',
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        formatter: function (w) {
                                            // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                            return {!! json_encode($budgets->sum('total')) !!}
                                        }
                                    }
                                }
                            }
                        },
                        labels: ['Total'],
                        colors: [success]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();
                }


                _demo2();
                _sales_analysis();
                _sales_target();
                _demo3();

            </script>
@endsection
