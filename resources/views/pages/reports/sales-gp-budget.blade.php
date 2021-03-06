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
                                               class="form-control {{$errors->has('first_date') ? 'is-invalid': ''}}"
                                               name="first_date" required id="kt_datepicker_1" readonly="readonly"
                                               placeholder="Sales Year">
                                        <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
                                        </div>
                                        @if($errors->has('first_date'))
                                            <div class="invalid-feedback">{{$errors->first('first_date')}}</div>
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
                                               class="form-control {{$errors->has('last_date') ? 'is-invalid': ''}}"
                                               name="last_date" required id="kt_datepicker_2" readonly="readonly"
                                               placeholder="Compared with a year">
                                        <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
                                        </div>
                                        @if($errors->has('last_date'))
                                            <div class="invalid-feedback">{{$errors->first('last_date')}}</div>
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

            @php
            $firstDate = request('first_date');
            $lastDate = request('last_date');
            @endphp

            <div class="row p-5">
                <table id="tableToExport" class="">
                    <table  class="table table-responsive-sm table-responsive-md " id="companyInfoTable">
                        <thead>
                        <tr>
                            <th colspan="4">Company Name:</th>
                            <th colspan="4">Meshkati Trading Co.</th>
                        </tr>
                        <tr>
                            <th colspan="4">Monthly Sales & Gross Margin</th>
                            <th colspan="4">({{$firstDate??$salesYear}} - {{$lastDate??$budgetYear}})  {{request('report_type') == 2 ? 'Actual With Budget' : ' Actual With Actual'}}</th>
                        </tr>

                        </thead>
                    </table>

                @if(count($actualSales))
                    <table  class="col-md-6  table-responsive-sm table-responsive-md table-responsive table table-vertical-center text-center" id="firstYearTable">
                        <thead>
                        <tr style="text-align: center" bgcolor="#d3d3d3" class="text-center">
                            <th>{{$salesYear}}</th>
                            <th colspan="2">Sales</th>
                            <th colspan="2">G.Profit</th>
                            <th colspan="2">% G.P</th>
                            <th colspan="1">N.Profit</th>
                            <th colspan="1">% N.P</th>
                        </tr>
                        <tr style="text-align: center" bgcolor="#d3d3d3" class="text-center">
                            <th></th>
                            <th>Monthly</th>
                            <th>Cumm</th>
                            <th>Monthly</th>
                            <th>Cumm</th>
                            <th>Monthly</th>
                            <th>Cumm</th>
                            <th>Cumm</th>
                           <th>Cumm</th>
                        </thead>
                        <tbody>
                        <tbody>
                        @foreach($actualSales as $key => $sale)
                            <tr style="text-align: center">
                                <td>{{$sale->monthName}}</td>
                                <td>{{moneyFormat($sale->net_sales)}}</td>
                                <td>{{moneyFormat($sale->net_sales_cum)}}</td>
                                <td>{{moneyFormat($sale->gross_profit)}}</td>
                                <td>{{moneyFormat($sale->gross_profit_cum)}}</td>
                                <td>{{$sale->rounded_gross_profit_percentage}}%</td>
                                <td>{{$sale->rounded_gross_profit_cum_percentage}}%</td>
                                <td>{{moneyFormat($sale->net_profit_cum)}}</td>
                                <td>{{$sale->rounded_net_profit_cum_percentage}}%</td>
                            </tr>
                        @endforeach
                        <tr style="text-align: center" bgcolor="#d3d3d3">
                            <td><strong>Total</strong></td>
                            <td><strong>{{moneyFormat($actualSales->sum('net_sales'))}}</strong></td>
                            <td></td>
                            <td><strong>{{moneyFormat($actualSales->sum('gross_profit'))}}</strong></td>
                            <td></td>
                            <td></td>
                            <td>
                                <strong>{{percentage($actualSales->sum('gross_profit'), $actualSales->sum('net_sales'))}}
                                    %</strong></td>
                            <td><strong>{{moneyFormat($actualSales->sum('net_profit'))}}</strong></td>
                            <td><strong>{{percentage($actualSales->sum('net_profit'), $actualSales->sum('net_sales'))}}%</strong></td>
                        </tr>
                        </tbody>
                    </table>
                @endif
                @if(count($budgetSales))
                    <table  class="col-md-6 table table-responsive-sm table-responsive-md table-responsive  table-vertical-center text-center" id="secondYearTable">
                        <thead>
                        <tr style="text-align: center" bgcolor="#d3d3d3" class="text-center">
                            <th>{{$budgetYear}}</th>
                            <th colspan="2">Sales</th>
                            <th colspan="2">G.Profit</th>
                            <th colspan="2">% G.P</th>
                            <th colspan="1">N.Profit</th>
                            <th colspan="1">% N.P</th>
                        </tr>
                        <tr style="text-align: center" bgcolor="#d3d3d3" class="text-center">
                            <th></th>
                            <th>Monthly</th>
                            <th>Cumm</th>
                            <th>Monthly</th>
                            <th>Cumm</th>
                            <th>Monthly</th>
                            <th>Cumm</th>
                            <th>Cumm</th>
                            <th>Cumm</th>
                        </thead>
                        <tbody>
                        <tbody>
                        @foreach($budgetSales as $key => $sale)
                            <tr style="text-align: center">
                                <td>{{$sale->monthName}}</td>
                                <td>{{moneyFormat($sale->net_sales)}}</td>
                                <td>{{moneyFormat($sale->net_sales_cum)}}</td>
                                <td>{{moneyFormat($sale->gross_profit)}}</td>
                                <td>{{moneyFormat($sale->gross_profit_cum)}}</td>
                                <td>{{$sale->rounded_gross_profit_percentage}}%</td>
                                <td>{{$sale->rounded_gross_profit_cum_percentage}}%</td>
                                <td>{{moneyFormat($sale->net_profit_cum)}}</td>
                                <td>{{$sale->rounded_net_profit_cum_percentage}}%</td>
                            </tr>
                        @endforeach
                        <tr style="text-align: center" bgcolor="#d3d3d3">
                            <td><strong>Total</strong></td>
                            <td><strong>{{moneyFormat($budgetSales->sum('net_sales'))}}</strong></td>
                            <td></td>
                            <td><strong>{{moneyFormat($budgetSales->sum('gross_profit'))}}</strong></td>
                            <td></td>
                            <td></td>
                            <td>
                                <strong>{{percentage($budgetSales->sum('gross_profit'), $budgetSales->sum('net_sales'))}}
                                    %</strong></td>
                            <td><strong>{{moneyFormat($budgetSales->sum('net_profit'))}}</strong></td>
                            <td><strong>{{percentage($budgetSales->sum('net_profit'), $budgetSales->sum('net_sales'))}}%</strong></td>
                        </tr>
                        </tbody>
                    </table>
                @endif
                </table>
            </div>

            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
                        <button id="exportBtn" type="button" class="btn btn-light-success font-weight-bold" >
                            Export To Excel
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



            $("#exportBtn").on("click", function () {
                toExcel();
            });

            function toExcel() {
                const mainTable = document.getElementById("tableToExport");
                const companyInfoTable = document.getElementById("companyInfoTable");
                const firstYearTable = document.getElementById("firstYearTable");
                const secondYearTable = document.getElementById("secondYearTable");

                companyInfoTable.style.border = '1px solid black';
                firstYearTable.style.border = '1px solid black';
                secondYearTable.style.border = '1px solid black';

                const mainTableOuterHtml = mainTable.outerHTML;
                const companyInfoTableOuterHtml = companyInfoTable.outerHTML + '<br />';
                const firstYearTableOuterHtml = firstYearTable.outerHTML + '<br />';
                const secondYearTableOuterHtml = secondYearTable.outerHTML + '<br />';
                let tab_text = mainTableOuterHtml+companyInfoTableOuterHtml+firstYearTableOuterHtml+'<br>'+secondYearTableOuterHtml;

                let a = document.createElement('a');
                let data_type = 'data:application/vnd.ms-excel';
                a.href = data_type+','+encodeURIComponent(tab_text);
                // sa = window.open('data:application/vnd.ms-excel;,' + encodeURIComponent(tab_text)+';filename=summary-report-'+(new Date()).toDateString());
                a.download = `sales-and-gp-{{$firstDate??$salesYear}}-{{$lastDate??$budgetYear}}-{{request('report_type') == 2 ? 'Actual With Budget' : 'Actual With Actual'}}`;
                //triggering the function
                a.click();
                companyInfoTable.style.border = '';
                firstYearTable.style.border = '';
                secondYearTable.style.border = '';
            }
        });

    </script>
@endsection
