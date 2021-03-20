{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
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

                <table id="tableToExport" >
                    <table class="table table-borderless" id="companyInfoTable">
                        <thead>
                        <tr>
                            <th colspan="2">Company Name:</th>
                            <th colspan="2">Meshkati Trading Co.</th>
                        </tr>
                        <tr>
                            <th class="" colspan="4">Monthly Sales & Sales Return</th>
                        </tr>

                        </thead>
                    </table>
                    @if(sizeof($firstYearSales))
                        <table class="mr- col-md-6 table table-bordered table-vertical-center text-center" id="firstYearTable">
                            <thead>
                            <tr bgcolor="#d3d3d3">
                                <th colspan="6" class="text-center">{{$firstYear}}</th>
                            </tr>
                            <tr bgcolor="#d3d3d3">
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
                                <tr>
                                    <td>{{$sale->monthName}}</td>
                                    <td>{{$sale->cash}}</td>
                                    <td>{{$sale->credit}}</td>
                                    <td>{{$sale->total}}</td>
                                    <td class="text-danger">{{$sale->returns}}</td>
                                    <td>{{$sale->net_sales}}</td>
                                </tr>
                            @endforeach
                            <tr bgcolor="#d3d3d3" class="text">
                                <th>TOTAL</th>
                                <th>{{$firstYearSales->sum('cash')}}</th>
                                <th>{{$firstYearSales->sum('credit')}}</th>
                                <th>{{$firstYearSales->sum('total')}}</th>
                                <th class="text-danger">({{$firstYearSales->sum('returns')}})</th>
                                <th>{{$firstYearSales->sum('net_sales')}}</th>
                            </tr>
                            <tr bgcolor="#d3d3d3" class="text-danger">
                                <th>%</th>
                                <th>{{round($firstYearSales->sum('cash') /$firstYearSales->sum('total') * 100,0)}}%</th>
                                <th>{{round($firstYearSales->sum('credit') /$firstYearSales->sum('total') * 100,0)}}%</th>
                                <th>{{round($firstYearSales->sum('total') /$firstYearSales->sum('total') * 100,0)}}%</th>
                                <th>-{{round($firstYearSales->sum('returns') /$firstYearSales->sum('total') * 100,0)}}%</th>
                                <th></th>
                            </tr>
                            </tbody>
                        </table>
                    @endif
                    @if(sizeof($secondYearSales))
                        <table  class="col-md-6 table table-bordered table-vertical-center text-center" id="secondYearTable">
                            <thead>
                            <tr bgcolor="#d3d3d3">
                                <th colspan="6" class="text-center">{{$secondYear}}</th>
                            </tr>
                            <tr bgcolor="#d3d3d3">
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
                                <tr>
                                    <td>{{$sale->monthName}}</td>
                                    <td>{{$sale->cash}}</td>
                                    <td>{{$sale->credit}}</td>
                                    <td>{{$sale->total}}</td>
                                    <td class="text-danger">{{$sale->returns}}</td>
                                    <td>{{$sale->net_sales}}</td>
                                </tr>
                            @endforeach
                            <tr bgcolor="#d3d3d3" class="text">
                                <th>TOTAL</th>
                                <th>{{$secondYearSales->sum('cash')}}</th>
                                <th>{{$secondYearSales->sum('credit')}}</th>
                                <th>{{$secondYearSales->sum('total')}}</th>
                                <th class="text-danger">({{$secondYearSales->sum('returns')}})</th>
                                <th>{{$secondYearSales->sum('net_sales')}}</th>
                            </tr>
                            <tr bgcolor="#d3d3d3" class="text-danger">
                                <th>%</th>
                                <th>{{round($secondYearSales->sum('cash') /$secondYearSales->sum('total') * 100,0)}}%</th>
                                <th>{{round($secondYearSales->sum('credit') /$secondYearSales->sum('total') * 100,0)}}%</th>
                                <th>{{round($secondYearSales->sum('total') /$secondYearSales->sum('total') * 100,0)}}%</th>
                                <th>-{{round($secondYearSales->sum('returns') /$secondYearSales->sum('total') * 100,0)}}%</th>
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
                const mainTable = document.getElementById("tableToExport").outerHTML;
                const companyInfoTable = document.getElementById("companyInfoTable").outerHTML;
                const firstYearTable = document.getElementById("firstYearTable").outerHTML;
                const secondYearTable = document.getElementById("secondYearTable").outerHTML;

                let tab_text = mainTable+companyInfoTable+firstYearTable+'<br>'+secondYearTable;
                let textRange;
                let j = 0;
                let sa;

                let ua = window.navigator.userAgent;
                let msie = ua.indexOf("MSIE ");
                if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
                {
                    let txt = document.getElementById('txtArea1').contentWindow;

                    txt.document.open("txt/html", "replace");
                    txt.document.write(tab_text);
                    txt.document.close();
                    txt.focus();
                    sa = txt.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
                }
                else {
                    let a = document.createElement('a');
                    let data_type = 'data:application/vnd.ms-excel';
                    a.href = data_type+','+encodeURIComponent(tab_text);
                    // sa = window.open('data:application/vnd.ms-excel;,' + encodeURIComponent(tab_text)+';filename=summary-report-'+(new Date()).toDateString());
                    a.download = `sales-analysis-and-comparative-${(new Date()).toDateString()}`;
                    //triggering the function
                    a.click();
                }
            }


        });
    </script>
@endsection
