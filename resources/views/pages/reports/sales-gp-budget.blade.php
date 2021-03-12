{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom overflow-hidden">
        <div class="card-body p-0">
            <!-- begin: Invoice-->
            <form class="form" method="get" action="{{route('reports.sales-and-gp-budge')}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <div class="">
                                    <div class="input-group date">
                                        <input type="text"
                                               class="form-control {{$errors->has('sales_year') ? 'is-invalid': ''}}"
                                               name="'" required id="kt_datepicker_1" readonly="readonly"
                                               placeholder="Sales Year">
                                        <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
                                        </div>
                                        @if($errors->has('sales_year'))
                                            <div class="invalid-feedback">{{$errors->first('sales_year')}}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <div class="">
                                    <div class="input-group date">
                                        <input type="text"
                                               class="form-control {{$errors->has('budget_date') ? 'is-invalid': ''}}"
                                               name="budget_date" required id="kt_datepicker_2" readonly="readonly"
                                               placeholder="Compared with a year">
                                        <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
                                        </div>
                                        @if($errors->has('budget_date'))
                                            <div class="invalid-feedback">{{$errors->first('budget_date')}}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-xs btn-default pl-5">
                                <i class="fa fa-search fa-1x text-info"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-9 col-form-label">
                            <div class="radio-inline">
                                <label class="radio radio-primary">
                                    <input value="1" type="radio" name="report_type" @if(request('report_type') == 1)  checked="checked" @endif @if(!request('report_type'))  checked="checked" @endif>
                                    <span></span>Actual with actual</label>
                                <label class="radio radio-primary">
                                    <input value="2" type="radio" name="report_type" @if(request('report_type') == 2)  checked="checked" @endif>
                                    <span></span>Actual with budget</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- begin: Invoice header-->
            <div class="row justify-content-center ">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                        <h1 class="display-4 font-weight-boldest mb-10">MISHKATI TRADING CO</h1>
                        <div class="d-flex flex-column align-items-md-end px-0">
                            <!--begin::Logo-->
                            <a href="#" class="mb-5">
                                <img src="assets/media/logos/logo-dark.png" alt="">
                            </a>
                            <!--end::Logo-->
                        </div>
                    </div>
                    <div class="border-bottom w-100"></div>
                    <div class="d-flex justify-content-between pt-6">
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">DATE</span>
                            <span class="opacity-70">{{$salesYear}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">DATE</span>
                            <span class="opacity-70">{{$budgetYear}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">Sales & GP - {{request('report_type') == 2 ?'Budget': 'Actual'}}</span>
                            <span class="opacity-70">
														<br>This Report Contains and GP (Actual & Budget)</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Invoice header-->
            <!-- begin: Invoice body-->
            <div class="row p-5">

                @if(count($actualSales))
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <p class="text-center"><strong>Actual - {{$salesYear}}</strong></p>
                            <table class="table table-bordered">
                                <thead>
                                <tr bgcolor="#d3d3d3" class="text-center">
                                    <th>{{$salesYear}}</th>
                                    <th colspan="2">Sales</th>
                                    <th colspan="2">G.Profit</th>
                                    <th colspan="2">% G.P</th>
                                    <th colspan="2">Net Profit Comm</th>
                                </tr>
                                <tr bgcolor="#d3d3d3" class="text-center">
                                    <th></th>

                                    <th>Monthly</th>
                                    <th>Cumm</th>
                                    <th>Monthly</th>
                                    <th>Cumm</th>
                                    <th>Monthly</th>
                                    <th>Cumm</th>
                                    <th colspan="2"></th>
                                </thead>
                                <tbody>
                                <tbody>
                                {{--                                @php--}}
                                {{--                                    $totalGprofit = 0;--}}
                                {{--                                    $totalGpPercentage = 0;--}}
                                {{--                                    $totalNetProfit = 0;--}}
                                {{--                                    $totalNetProfitPercentage = 0;--}}
                                {{--                                    $lastTotalGpPercentage = 0;--}}
                                {{--                                    $lastNetProfitComm = 0;--}}
                                {{--                                @endphp--}}
                                @foreach($actualSales as $key => $sale)
                                    {{--                                    @php--}}
                                    {{--                                        $sales = $sale->net;--}}
                                    {{--                                        $salesCumm = $key === 0 ? $sale->net : $sale->net + $currentYearSales[$key - 1]->net;--}}
                                    {{--                                        $gProfit = $sale->net - $sale->expenses;--}}
                                    {{--                                        $totalGprofit+= $gProfit;--}}
                                    {{--                                        $gProfitCumm = $key === 0 ? $gProfit : $gProfit + ($currentYearSales[$key-1]->net - $currentYearSales[$key-1]->expenses);--}}
                                    {{--                                        $gpPercentage = round($gProfit / $sales * 100,2);--}}
                                    {{--                                        $totalGpPercentage += $gpPercentage;--}}
                                    {{--                                        $gpPercentageCumm = $key === 0 ? $gpPercentage : round($gProfitCumm / $salesCumm * 100,2);--}}
                                    {{--                                        $lastTotalGpPercentage = $gpPercentageCumm;--}}
                                    {{--                                        $netProfit = $gProfit;--}}
                                    {{--                                        $netProfitPercentage = round($netProfit / $salesCumm * 100,2);--}}
                                    {{--                                        $lastNetProfitComm = $netProfitPercentage;--}}
                                    {{--                                    @endphp--}}
                                    <tr>
                                        <td>{{$sale->monthName}}</td>
                                        <td>{{$sale->net}}</td>
                                        <td>{{$sale->net_sales_cum}}</td>
                                        <td>{{$sale->g_profit}}</td>
                                        <td>{{$sale->g_profit_cum}}</td>
                                        <td>{{$sale->g_profit_percentage}}%</td>
                                        <td>{{$sale->g_profit_cum_percentage}}%</td>
                                        <td>{{$sale->net_profit}}</td>
                                        <td>{{$sale->net_profit_percentage}}%</td>
                                    </tr>
                                @endforeach
                                <tr bgcolor="#d3d3d3">
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{$actualSales->sum('net')}}</strong></td>
                                    <td></td>
                                    <td><strong>{{$actualSales->sum('g_profit')}}</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <strong>{{round($actualSales->sum('g_profit') / $actualSales->sum('net') * 100,2)}}
                                            %</strong></td>
                                    <td></td>
                                    <td><strong>{{$actualSales->values()->last()->net_profit}}%</strong></td>
                                </tr>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if(count($budgetSales))
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <p class="text-center"><strong>{{request('report_type') == 2 ?'Budget': 'Actual'}} - {{$budgetYear}}</strong></p>
                            <table class="table table-bordered">
                                <thead>
                                <tr bgcolor="#d3d3d3" class="text-center">
                                    <th>{{$budgetYear}}</th>
                                    <th colspan="2">Sales</th>
                                    <th colspan="2">G.Profit</th>
                                    <th colspan="2">% G.P</th>
                                    <th colspan="2">Net Profit Comm</th>
                                </tr>
                                <tr bgcolor="#d3d3d3" class="text-center">
                                    <th></th>

                                    <th>Monthly</th>
                                    <th>Cumm</th>
                                    <th>Monthly</th>
                                    <th>Cumm</th>
                                    <th>Monthly</th>
                                    <th>Cumm</th>
                                    <th colspan="2"></th>
                                </thead>
                                <tbody>
                                {{--                                    @php--}}
                                {{--                                        $totalGprofit = 0;--}}
                                {{--                                        $totalGpPercentage = 0;--}}
                                {{--                                        $totalNetProfit = 0;--}}
                                {{--                                        $totalNetProfitPercentage = 0;--}}
                                {{--                                        $lastTotalGpPercentage = 0;--}}
                                {{--                                        $lastNetProfitComm = 0;--}}
                                {{--                                    @endphp--}}
                                @foreach($budgetSales as $key => $sale)
                                    {{--                                    @php--}}
                                    {{--                                        $sales = $sale->net;--}}
                                    {{--                                        $salesCumm = $key === 0 ? $sale->net : $sale->net + $currentYearBudget[$key - 1]->net;--}}
                                    {{--                                        $gProfit = $sale->net - $sale->expenses;--}}
                                    {{--                                        $totalGprofit+= $gProfit;--}}
                                    {{--                                        $gProfitCumm = $key === 0 ? $gProfit : $gProfit + ($currentYearBudget[$key-1]->net - $currentYearBudget[$key-1]->expenses);--}}
                                    {{--                                        $gpPercentage = round($gProfit / $sales * 100,2);--}}
                                    {{--                                        $totalGpPercentage += $gpPercentage;--}}
                                    {{--                                        $gpPercentageCumm = $key === 0 ? $gpPercentage : round($gProfitCumm / $salesCumm * 100,2);--}}
                                    {{--                                        $lastTotalGpPercentage = $gpPercentageCumm;--}}
                                    {{--                                        $netProfit = $gProfit;--}}
                                    {{--                                        $netProfitPercentage = round($netProfit / $salesCumm * 100,2);--}}
                                    {{--                                        $lastNetProfitComm = $netProfitPercentage;--}}
                                    {{--                                    @endphp--}}
                                    <tr>
                                        <td>{{$sale->monthName}}</td>
                                        <td>{{$sale->net}}</td>
                                        <td>{{$sale->net_sales_cum}}</td>
                                        <td>{{$sale->g_profit}}</td>
                                        <td>{{$sale->g_profit_cum}}</td>
                                        <td>{{$sale->g_profit_percentage}}%</td>
                                        <td>{{$sale->g_profit_cum_percentage}}%</td>
                                        <td>{{$sale->net_profit}}</td>
                                        <td>{{$sale->net_profit_percentage}}%</td>
                                    </tr>
                                @endforeach
                                <tr bgcolor="#d3d3d3">
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{$budgetSales->sum('net')}}</strong></td>
                                    <td></td>
                                    <td><strong>{{$budgetSales->sum('g_profit')}}</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <strong>{{round($budgetSales->sum('g_profit') / $budgetSales->sum('net') * 100,2)}}
                                            %</strong></td>
                                    <td></td>
                                    <td><strong>{{$budgetSales->values()->last()->net_profit}}%</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">
                            Download Report
                        </button>
                        <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print
                            Report
                        </button>
                    </div>
                </div>
            </div>
            <!-- end: Invoice action-->
            <!-- end: Invoice-->
        </div>
    </div>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script>
        jQuery(document).ready(function () {
            $('#kt_datepicker_1').datepicker({
                orientation: "bottom left",
                format: "yyyy",
                startView: "years",
                minViewMode: "years",
                // startDate: new Date(),
                // endDate: new Date(),
                autoclose: true,

            });

            $('#kt_datepicker_2').datepicker({
                orientation: "bottom left",
                format: "yyyy",
                startView: "years",
                minViewMode: "years",
                // startDate: new Date(),
                // endDate: new Date(),
                autoclose: true,

            });


        });

    </script>
@endsection
