{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    @can('read_dashboard')
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
    @endcan



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
                        series:[ {!! json_encode($currentYearSales->sum('cash')) !!}, {!! json_encode($currentYearSales->sum('credit')) !!}, {!! json_encode($currentYearSales->sum('returns')) !!}],
                        chart: {
                            width: 380,
                            type: 'pie',
                        },
                        labels: ['Cash', 'Credit','Returns'],
                        dataLabels: {
                            formatter: function (val, opts) {
                                return opts.w.config.series[opts.seriesIndex] + " SAR"
                            },
                        },
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
                            data: {!! json_encode($currentYearSales->pluck('net_sales')) !!}
                        }, {
                            name: 'Gross Profit',
                            data:{!! json_encode($currentYearSales->pluck('gross_profit')) !!}
                        }, {
                            name: 'Net Profit',
                            data: {!! json_encode($currentYearSales->pluck('net_profit')) !!}
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
                            categories: {!! json_encode($currentYearSalesMonths) !!},
                        },
                        yaxis: {
                            title: {
                                text: 'SAR (thousands)'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "SAR " + val + " thousands"
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
                        chart: {
                            height: 280,
                            type: "radialBar",
                        },

                        series: [{!! sizeof($budgets) > 0 ?  round($currentYearSales->sum('total') / $budgets->sum('total') * 100,0) : 0 !!}],
                        colors: ["#20E647"],
                        plotOptions: {
                            radialBar: {
                                hollow: {
                                    margin: 0,
                                    size: "70%",
                                    background: "#293450"
                                },
                                track: {
                                    dropShadow: {
                                        enabled: true,
                                        top: 2,
                                        left: 0,
                                        blur: 4,
                                        opacity: 0.15
                                    }
                                },
                                dataLabels: {
                                    name: {
                                        offsetY: -10,
                                        color: "#fff",
                                        fontSize: "13px"
                                    },
                                    value: {
                                        color: "#fff",
                                        fontSize: "30px",
                                        show: true
                                    }
                                }
                            }
                        },
                        fill: {
                            type: "gradient",
                            gradient: {
                                shade: "dark",
                                type: "vertical",
                                gradientToColors: ["#87D4F9"],
                                stops: [0, 100]
                            }
                        },
                        stroke: {
                            lineCap: "round"
                        },
                        labels: ["Progress"]
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
