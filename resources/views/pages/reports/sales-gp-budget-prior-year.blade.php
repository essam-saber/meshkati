{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom overflow-hidden">
        <div class="card-body p-0">
            <!-- begin: Invoice-->
            <!-- begin: Invoice header-->
            <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
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
                            <span class="opacity-70">{{$currentYear}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">DATE END</span>
                            <span class="opacity-70">{{$priorYear}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">Sales & GP - Budget Prior Year</span>
                            <span class="opacity-70">
														<br>This report contains the actual sales for the current and prior year</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Invoice header-->
            <!-- begin: Invoice body-->
            <div class="row p-5">

                @if(count($currentYearSales))
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <p class="text-center"><strong>Actual - {{$currentYear}}</strong></p>
                            <table class="table table-bordered">
                                <thead>
                                <tr bgcolor="#d3d3d3" class="text-center">
                                    <th>{{$currentYear}}</th>
                                    <th colspan="2">Sales </th>
                                    <th colspan="2">G.Profit </th>
                                    <th colspan="2">% G.P </th>
                                    <th colspan="2">Net Profit Comm </th>
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
                                @php
                                    $totalGprofit = 0;
                                    $totalGpPercentage = 0;
                                    $totalNetProfit = 0;
                                    $totalNetProfitPercentage = 0;
                                    $lastTotalGpPercentage = 0;
                                    $lastNetProfitComm = 0;
                                @endphp
                                @foreach($currentYearSales as $key => $sale)
                                    @php
                                        $sales = $sale->net;
                                        $salesCumm = $key === 0 ? $sale->net : $sale->net + $currentYearSales[$key - 1]->net;
                                        $gProfit = $sale->net - $sale->expenses;
                                        $totalGprofit+= $gProfit;
                                        $gProfitCumm = $key === 0 ? $gProfit : $gProfit + ($currentYearSales[$key-1]->net - $currentYearSales[$key-1]->expenses);
                                        $gpPercentage = round($gProfit / $sales * 100,2);
                                        $totalGpPercentage += $gpPercentage;
                                        $gpPercentageCumm = $key === 0 ? $gpPercentage : round($gProfitCumm / $salesCumm * 100,2);
                                        $lastTotalGpPercentage = $gpPercentageCumm;
                                        $netProfit = $gProfit;
                                        $netProfitPercentage = round($netProfit / $salesCumm * 100,2);
                                        $lastNetProfitComm = $netProfitPercentage;
                                    @endphp
                                    <tr>
                                        <td>{{$sale->monthName}}</td>
                                        <td>{{$sales}}</td>
                                        <td>{{$salesCumm}}</td>
                                        <td>{{$gProfit}}</td>
                                        <td>{{$gProfitCumm}}</td>
                                        <td>{{$gpPercentage}}%</td>
                                        <td>{{$gpPercentageCumm}}%</td>
                                        <td>{{$netProfit}}</td>
                                        <td>{{$netProfitPercentage}}%</td>
                                    </tr>
                                @endforeach
                                <tr bgcolor="#d3d3d3" >
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{$currentYearSales->sum('net')}}</strong></td>
                                    <td></td>
                                    <td><strong>{{$totalGprofit}}</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>{{$lastTotalGpPercentage}}%</strong></td>
                                    <td></td>
                                    <td><strong>{{$lastNetProfitComm}}%</strong></td>
                                </tr>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if(count($priorYearSales))
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <p class="text-center"><strong>Actual - {{$priorYear}}</strong></p>
                            <table class="table table-bordered">
                                <thead>
                                <tr bgcolor="#d3d3d3" class="text-center">
                                    <th>{{$priorYear}}</th>
                                    <th colspan="2">Sales </th>
                                    <th colspan="2">G.Profit </th>
                                    <th colspan="2">% G.P </th>
                                    <th colspan="2">Net Profit Comm </th>
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
                                    @php
                                        $totalGprofit = 0;
                                        $totalGpPercentage = 0;
                                        $totalNetProfit = 0;
                                        $totalNetProfitPercentage = 0;
                                        $lastTotalGpPercentage = 0;
                                        $lastNetProfitComm = 0;
                                    @endphp
                                @foreach($priorYearSales as $key => $sale)
                                    @php
                                        $sales = $sale->net;
                                        $salesCumm = $key === 0 ? $sale->net : $sale->net + $priorYearSales[$key - 1]->net;
                                        $gProfit = $sale->net - $sale->expenses;
                                        $totalGprofit+= $gProfit;
                                        $gProfitCumm = $key === 0 ? $gProfit : $gProfit + ($priorYearSales[$key-1]->net - $priorYearSales[$key-1]->expenses);
                                        $gpPercentage = round($gProfit / $sales * 100,2);
                                        $totalGpPercentage += $gpPercentage;
                                        $gpPercentageCumm = $key === 0 ? $gpPercentage : round($gProfitCumm / $salesCumm * 100,2);
                                        $lastTotalGpPercentage = $gpPercentageCumm;
                                        $netProfit = $gProfit;
                                        $netProfitPercentage = round($netProfit / $salesCumm * 100,2);
                                        $lastNetProfitComm = $netProfitPercentage;
                                    @endphp
                                    <tr>
                                        <td>{{$sale->monthName}}</td>
                                        <td>{{$sales}}</td>
                                        <td>{{$salesCumm}}</td>
                                        <td>{{$gProfit}}</td>
                                        <td>{{$gProfitCumm}}</td>
                                        <td>{{$gpPercentage}}%</td>
                                        <td>{{$gpPercentageCumm}}%</td>
                                        <td>{{$netProfit}}</td>
                                        <td>{{$netProfitPercentage}}%</td>
                                    </tr>
                                @endforeach
                                    <tr bgcolor="#d3d3d3" >
                                        <td><strong>Total</strong></td>
                                        <td><strong>{{$priorYearSales->sum('net')}}</strong></td>
                                        <td></td>
                                        <td><strong>{{$totalGprofit}}</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>{{$lastTotalGpPercentage}}%</strong></td>
                                        <td></td>
                                        <td><strong>{{$lastNetProfitComm}}%</strong></td>
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
                        <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Download Report</button>
                        <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print Report</button>
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

@endsection
