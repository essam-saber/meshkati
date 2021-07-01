{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    @php
       $firstDate = request('first_date');
        $lastDate = request('second_date');
    @endphp
    <div class="card card-custom overflow-hidden">
        <div class="card-body p-0">
            <!-- begin: Invoice-->
            <!-- begin: Invoice header-->
            <form class="form" method="get" action="{{route('reports.sales-analysis-and-comparative')}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <div class="">
                                    <div class="input-group date">
                                        <input type="text"
                                               class="form-control {{$errors->has('first_date') ? 'is-invalid': ''}}"
                                               name="first_date" required id="kt_datepicker_1" readonly="readonly"
                                               placeholder="Select a year">
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
                                               class="form-control {{$errors->has('second_date') ? 'is-invalid': ''}}"
                                               name="second_date" required id="kt_datepicker_2" readonly="readonly"
                                               placeholder="with a year">
                                        <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
                                        </div>
                                        @if($errors->has('second_date'))
                                            <div class="invalid-feedback">{{$errors->first('second_date')}}</div>
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
                </div>
            </form>
            <!-- end: Invoice header-->
            <!-- begin: Invoice body-->
            <div class="row p-5" id="">

                <table id="tableToExport">
                    <table class="table table-vertical-center text-center" id="companyInfoTable" >
                        <thead>
                        <tr class="">
                            <th colspan="3">Company Name:</th>
                            <th colspan="3">Meshkati Trading Co.</th>
                        </tr>
                        <tr>
                            <th colspan="6">Monthly Sales & Sales Return</th>
                        </tr>

                        </thead>
                    </table>
                    @if(sizeof($firstYearSales))
                        <table class="col-md-6 table  table-vertical-center text-center table-responsive-md table-responsive-sm table-responsive" id="firstYearTable">
                            <thead>
                            <tr style="text-align: center" bgcolor="#d3d3d3">
                                <th colspan="6" class="text-center">{{$firstDate??$firstYear}}</th>
                            </tr>
                            <tr style="text-align: center" bgcolor="#d3d3d3">
                                <th>{{$firstYear}}</th>
                                <th>Cash Sales</th>
                                <th>Credit Sales</th>
                                <th>Total</th>
                                <th>Sales Returns</th>
                                <th>Net Sales</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($firstYearSales as $sale)
                                <tr style="text-align: center">
                                    <td>{{$sale->monthName}}</td>
                                    <td>{{moneyFormat($sale->cash)}}</td>
                                    <td>{{moneyFormat($sale->credit)}}</td>
                                    <td>{{moneyFormat($sale->total)}}</td>
                                    <td class="text-danger" style="color: red">{{moneyFormat($sale->returns)}}</td>
                                    <td>{{moneyFormat($sale->net_sales)}}</td>
                                </tr>
                            @endforeach
                            <tr style="text-align: center" bgcolor="#d3d3d3" class="text">
                                <th>TOTAL</th>
                                <th>{{moneyFormat($firstYearSales->sum('cash'))}}</th>
                                <th>{{moneyFormat($firstYearSales->sum('credit'))}}</th>
                                <th>{{moneyFormat($firstYearSales->sum('total'))}}</th>
                                <th class="text-danger" style="color: red">({{moneyFormat($firstYearSales->sum('returns'))}})</th>
                                <th>{{moneyFormat($firstYearSales->sum('net_sales'))}}</th>
                            </tr>
                            <tr bgcolor="#d3d3d3" class="text-danger" style="color: red; text-align: center">
                                <th>%</th>
                                <th>{{percentage($firstYearSales->sum('cash'), $firstYearSales->sum('total'))}}%</th>
                                <th>{{percentage($firstYearSales->sum('credit'), $firstYearSales->sum('total'))}}%</th>
                                <th>{{percentage($firstYearSales->sum('total'), $firstYearSales->sum('total') )}}%</th>
                                <th>-{{percentage($firstYearSales->sum('returns'), $firstYearSales->sum('total'))}}%</th>
                                <th></th>
                            </tr>
                            </tbody>
                        </table>
                    @endif
                    @if(sizeof($secondYearSales))
                        <table  class="col-md-6 table  table-vertical-center text-center table-responsive-md table-responsive-sm table-responsive"  id="secondYearTable">
                            <thead>
                            <tr style="text-align: center" bgcolor="#d3d3d3">
                                <th colspan="6" class="text-center">{{$lastDate??$secondYear}}</th>
                            </tr>
                            <tr style="text-align: center" bgcolor="#d3d3d3">
                                <th>{{$secondYear}}</th>
                                <th>Cash Sales</th>
                                <th>Credit Sales</th>
                                <th>Total</th>
                                <th>Sales Returns</th>
                                <th>Net Sales</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($secondYearSales as $sale)
                                <tr style="text-align: center">
                                    <td>{{$sale->monthName}}</td>
                                    <td>{{moneyFormat($sale->cash)}}</td>
                                    <td>{{moneyFormat($sale->credit)}}</td>
                                    <td>{{moneyFormat($sale->total)}}</td>
                                    <td style="color: red" class="text-danger">{{moneyFormat($sale->returns)}}</td>
                                    <td>{{moneyFormat($sale->net_sales)}}</td>
                                </tr>
                            @endforeach
                            <tr style="text-align: center" bgcolor="#d3d3d3" class="text">
                                <th>TOTAL</th>
                                <th>{{moneyFormat($secondYearSales->sum('cash'))}}</th>
                                <th>{{moneyFormat($secondYearSales->sum('credit'))}}</th>
                                <th>{{moneyFormat($secondYearSales->sum('total'))}}</th>
                                <th class="text-danger" style="color: black">({{moneyFormat($secondYearSales->sum('returns'))}})</th>
                                <th>{{moneyFormat($secondYearSales->sum('net_sales'))}}</th>
                            </tr>
                            <tr style="color: red; text-align: center;" bgcolor="#d3d3d3" class="text-danger">
                                <th>%</th>
                                <th>{{percentage($secondYearSales->sum('cash'), $secondYearSales->sum('total'))}}%</th>
                                <th>{{percentage($secondYearSales->sum('credit'), $secondYearSales->sum('total'))}}%</th>
                                <th>{{percentage($secondYearSales->sum('total'), $secondYearSales->sum('total') )}}%</th>
                                <th>-{{percentage($secondYearSales->sum('returns'), $secondYearSales->sum('total'))}}%</th>
                                <th></th>
                            </tr>
                            </tbody>
                        </table>

                    @endif
              </table>

            </div>

            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print
                            Report
                        </button>
                        <button type="button" class="btn btn-success font-weight-bold" id="exportBtn"><i
                                    class="fa fa-file-excel"></i>Export to Excel
                        </button>
                    </div>
                </div>
            </div>
            <!-- end: Invoice action-->
            <!-- end: Invoice-->
        </div>
    </div>
@endsection
@section('styles')

    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

@endsection
{{-- Scripts Section --}}
@section('scripts')
    {{--        <script type="text/javascript" src="//www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
    --}}
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
                a.download = `sales-analysis-and-comparative-{{$firstDate??$firstYear}}-with-{{$lastDate??$secondYear}}`;
                //triggering the function
                a.click();
                companyInfoTable.style.border = '';
                firstYearTable.style.border = '';
                secondYearTable.style.border = '';
            }


        });
    </script>
@endsection
