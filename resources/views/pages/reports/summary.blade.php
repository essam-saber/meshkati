{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom overflow-hidden">
        <div class="card-body p-0">
            <!-- begin: Invoice-->
            <form class="form" method="get" action="{{route('reports.summary')}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <div class="">
                                    <div class="input-group date">
                                        <input type="text"
                                               class="form-control {{$errors->has('date') ? 'is-invalid': ''}}"
                                               name="date" required id="kt_datepicker_1" readonly="readonly"
                                               placeholder="Date">
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
                        <div class="col-md-1">
                            <button class="btn btn-xs btn-default pl-5">
                                <i class="fa fa-search fa-1x text-info"></i>
                            </button>
                        </div>
                        <div class="col-md-7">
                            <div class="alert alert-custom alert-notice alert-light-primary fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">
                                    <p>Please choose a date and press search button to get the summary report</p>
                                    <p>If there is many zero values, it means that there is no available data for the selected month !.</p>
                                </div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>



            <!-- begin: Invoice body-->
            <div class="row p-5 align-items-center">
            @if($showReport)
                   <table id="tableToExport" class="">
                       <table style="" class="table table-responsive-sm table-responsive-md table-bordered table-vertical-center"  id="companyInfoTable">
                           <thead>
                           <tr>
                               <th colspan="4">Company Name:</th>
                               <th colspan="4">Meshkati Trading Co.</th>
                           </tr>
                           <tr>
                               <th colspan="4">Monthly Update Report:</th>

                               <th colspan="4">Date: {{getFormatSummaryReportDate(request('date'))}}</th>
                           </tr>

                           </thead>
                       </table>
                       <hr>
                       <table style="" class="table table-responsive-sm table-responsive-md table-bordered table-vertical-center text-center" id="salesResultTable">
                           <thead>
                           <tr style="text-align: center">
                               <th colspan="8">
                                Monthly Results Compared With Budget & Previous Year
                               </th>
                           </tr>
                           <tr style="text-align: center" bgcolor="#d3d3d3">
                               <th rowspan="2">Description</th>
                               <th colspan="2">Actual - This Month</th>
                               <th colspan="2">Budget - This Month</th>
                               <th colspan="2">Actual - Comparative Month</th>
                           </tr>
                           <tr style="text-align: center" bgcolor="#d3d3d3">
                               <th>SR</th>
                               <th>%</th>
                               <th>SR</th>
                               <th>%</th>
                               <th>SR</th>
                               <th>%</th>
                           </tr>
                           </thead>
                           <tbody>
                           @if(!is_null($actualSalesForCurrentMonth))
                               <tr style="text-align: center">
                                   <td >Sales (net)</td>
                                   <td>{{moneyFormat($actualSalesForCurrentMonth->net_sales??0) }}</td>
                                   <td></td>
                                   <td>{{moneyFormat($budgetSalesForCurrentMonth->net_sales??0) }}</td>
                                   <td>
                                   <td>{{moneyFormat($actualSalesForCurrentMonthPrevYear->net_sales??0) }}</td>
                                   <td></td>
                               </tr>
                               <tr style="text-align: center">
                                   <td >Gross Margin</td>
                                   <td>{{moneyFormat($actualSalesForCurrentMonth->gross_profit??0)}}</td>
                                   <td>{{$actualSalesForCurrentMonth->gross_profit_percentage??0}}%</td>
                                   <td>{{moneyFormat($budgetSalesForCurrentMonth->gross_profit??0)}}</td>
                                   <td>{{$budgetSalesForCurrentMonth->gross_profit_percentage??0}}%</td>
                                   <td>{{moneyFormat($actualSalesForCurrentMonthPrevYear->gross_profit??0)}}</td>
                                   <td>{{$actualSalesForCurrentMonthPrevYear->gross_profit_percentage??0}}%</td>
                               </tr>
                               <tr style="text-align: center">
                                   <td >Net Profit</td>
                                   <td>{{moneyFormat($actualSalesForCurrentMonth->net_profit??0)}}</td>
                                   <td>{{$actualSalesForCurrentMonth->net_profit_percentage??0}}%</td>
                                   <td>{{moneyFormat($budgetSalesForCurrentMonth->net_profit??0)}}</td>
                                   <td>{{$budgetSalesForCurrentMonth->net_profit_percentage??0}}%</td>
                                   <td>{{moneyFormat($actualSalesForCurrentMonthPrevYear->net_profit??0)}}</td>
                                   <td>{{$actualSalesForCurrentMonthPrevYear->net_profit_percentage??0}}%</td>
                               </tr>
                           @else
                               <tr style="text-align: center">
                                   <td colspan="7">No available data</td>
                               </tr>
                           @endif

                           </tbody>
                       </table>
                       <hr>
                       <table style="" class="table table-responsive-sm table-responsive-md table-bordered table-vertical-center text-center" id="cumResultTable">
                           <thead>
                           <tr style="text-align: center">
                               <th colspan="8">
                                   Cumulative Results Compared With Budget & Previous Year
                               </th>
                           </tr>
                           <tr style="text-align: center" bgcolor="#d3d3d3">
                               <th rowspan="2">Description</th>
                               <th colspan="2">Actual - Cumulative</th>
                               <th colspan="2">Budget - Cumulative</th>
                               <th colspan="2">Actual - Comparative Cumulative</th>
                           </tr>
                           <tr style="text-align: center" bgcolor="#d3d3d3">
                               <th>SR</th>
                               <th>%</th>
                               <th>SR</th>
                               <th>%</th>
                               <th>SR</th>
                               <th>%</th>
                           </tr>
                           </thead>
                           <tbody>
                            @if(!is_null($actualSalesForCurrentMonth))
                                <tr style="text-align: center">
                                    <td >Sales (net)</td>
                                    <td>{{moneyFormat($actualSalesForCurrentMonth->net_sales_cum??0)}}</td>
                                    <td></td>
                                    <td>{{moneyFormat($budgetSalesForCurrentMonth->net_sales_cum??0)}}</td>
                                    <td></td>
                                    <td>{{moneyFormat($actualSalesForCurrentMonthPrevYear->net_sales_cum??0)}}</td>
                                    <td></td>
                                </tr>
                                <tr style="text-align: center">
                                    <td >Gross Margin</td>
                                    <td>{{moneyFormat($actualSalesForCurrentMonth->gross_profit_cum??0)}}</td>
                                    <td>{{$actualSalesForCurrentMonth->gross_profit_cum_percentage??0}}%</td>
                                    <td>{{moneyFormat($budgetSalesForCurrentMonth->gross_profit_cum??0)}}</td>
                                    <td>{{$budgetSalesForCurrentMonth->gross_profit_cum_percentage??0}}%</td>
                                    <td>{{moneyFormat($actualSalesForCurrentMonthPrevYear->gross_profit_cum??0)}}</td>
                                    <td>{{$actualSalesForCurrentMonthPrevYear->gross_profit_cum_percentage??0}}%</td>
                                </tr>
                                <tr style="text-align: center">
                                    <td >Net Profit</td>
                                    <td>{{moneyFormat($actualSalesForCurrentMonth->net_profit_cum??0)}}</td>
                                    <td>{{$actualSalesForCurrentMonth->net_profit_cum_percentage??0}}%</td>
                                    <td>{{moneyFormat($budgetSalesForCurrentMonth->net_profit_cum??0)}}</td>
                                    <td>{{$budgetSalesForCurrentMonth->net_profit_cum_percentage??0}}%</td>
                                    <td>{{moneyFormat($actualSalesForCurrentMonthPrevYear->net_profit_cum??0)}}</td>
                                    <td>{{$actualSalesForCurrentMonthPrevYear->net_profit_cum_percentage??0}}%</td>
                                </tr>
                            @else
                                <tr style="text-align: center">
                                    <td colspan="7">No available data</td>
                                </tr>
                           @endif
                           </tbody>
                       </table>
                       <hr>
                       <table style="" class="table table-responsive-sm table-responsive-md table-bordered table-vertical-center text-center" id="debitTable">
                           <thead>
                           <tr style="text-align: center">
                               <th colspan="8">
                                   Showing of Debit Trade Accounts Receivable
                               </th>
                           </tr>
                           <tr style="text-align: center" bgcolor="#d3d3d3">
                               <th rowspan="2">Description</th>
                              @foreach($agingOfDebit as $age )
                                   @if($age->attribute->slug !== 'less-credit' && $age->attribute->slug !== 'ar-provision')
                                       <th>{{$age->attribute->name}}</th>
                                 @endif
                              @endforeach
                           </tr>
                           <tr style="text-align: center" bgcolor="#d3d3d3">
                               <th>SR</th>
                               <th>SR</th>
                               <th>SR</th>
                               <th>SR</th>
                               <th>SR</th>
                               <th>SR</th>
                           </tr>
                           </thead>
                            <tbody>
                            <tr style="text-align: center">
                                <td >Aging</td>
                                @php
                                    $ageOfDebitSum = 0;;
                                @endphp
                                @foreach($agingOfDebit as $age)
                                    @if($age->attribute->slug !== 'less-credit' && $age->attribute->slug !== 'ar-provision')
                                        <td>{{moneyFormat($age->value)}}</td>
                                        @php
                                            $ageOfDebitSum += $age->value;
                                        @endphp
                                    @endif
                                @endforeach
                            </tr>
                            <tr style="text-align: center">
                                <td>% Represent From Balance</td>
                                @foreach($agingOfDebit as $age)
                                    @if($age->attribute->slug !== 'less-credit' && $age->attribute->slug !== 'ar-provision')
                                        <td>{{percentage($age->value, $ageOfDebitSum)}}%</td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr style="text-align: center">
                                <td>Total Debit A/R</td>
                                <td bgcolor="#e5e3e3" colspan="6">{{moneyFormat($ageOfDebitSum)}}</td>
                            </tr>
                            <tr style="text-align: center">
                                <td>Less Credit A/R</td>
                                <td colspan="6" style="color: red">

                                    @foreach($agingOfDebit as $age)
                                        @if($age->attribute->slug == 'less-credit')
                                            <span class="text-danger">{{ '('.moneyFormat($age->value).')'}}</span>
                                        @endif
                                    @endforeach

                                </td>
                            </tr>
                            <tr style="text-align: center">
                                <td>Net A/R Balances</td>
                                <td bgcolor="#e5e3e3" colspan="6">
                                    @foreach($agingOfDebit as $age)
                                        @if($age->attribute->slug == 'less-credit')
                                            {{moneyFormat($ageOfDebitSum - $age->value)}}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr style="text-align: center">
                                <td>A/R Provision</td>
                                <td bgcolor="#e5e3e3" colspan="6" style="color: red">
                                    @foreach($agingOfDebit as $age)
                                        @if($age->attribute->slug == 'ar-provision')
                                            <span class="text-danger">
                                                {{moneyFormat($age->value) }}
                                            </span>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            </tbody>
                       </table>
                       <hr>
                       <table style="" class="table table-responsive-sm table-responsive-md table-bordered table-vertical-center text-center" id="inventory">
                           <thead>
                           <tr style="text-align: center">
                               <th colspan="8">
                                   Inventory
                               </th>
                           </tr>
                           <tr style="text-align: center" bgcolor="#d3d3d3">
                               <th rowspan="2">Description</th>
                               <th>Goods Ready For Sale</th>
                               <th>Finished Products</th>
                               <th>Semi-Finished Products</th>
                               <th>Work In Process</th>
                               <th>Raw Materials</th>
                               <th>Spare Parts & Others</th>
                           </tr>
                           <tr style="text-align: center" bgcolor="#d3d3d3">
                               <th>SR</th>
                               <th>SR</th>
                               <th>SR</th>
                               <th>SR</th>
                               <th>SR</th>
                               <th>SR</th>
                           </tr>
                           </thead>
                           <tbody>
                            @if(!is_null($inventory))
                                <tr style="text-align: center">
                                    <td>Inventory Category</td>
                                    <td>{{moneyFormat($inventory->goods_ready_for_sale)}}</td>
                                    <td>{{moneyFormat($inventory->finished_products)}}</td>
                                    <td>{{moneyFormat($inventory->semi_finished_products)}}</td>
                                    <td>{{moneyFormat($inventory->work_in_process)}}</td>
                                    <td>{{moneyFormat($inventory->raw_materials)}}</td>
                                    <td>{{moneyFormat($inventory->spare_parts_and_others)}}</td>
                                </tr>
                                <tr style="text-align: center">
                                    <td>% of Balance</td>
                                    <td>{{percentage($inventory->goods_ready_for_sale , $inventory->total)}}%</td>
                                    <td>{{percentage($inventory->finished_products , $inventory->total)}}%</td>
                                    <td>{{percentage($inventory->semi_finished_products , $inventory->total)}}%</td>
                                    <td>{{percentage($inventory->work_in_process , $inventory->total)}}%</td>
                                    <td>{{percentage($inventory->raw_materials , $inventory->total)}}%</td>
                                    <td>{{percentage($inventory->spare_parts_and_others , $inventory->tota)}}%</td>
                                </tr>
                                <tr style="text-align: center">
                                    <td>Total</td>
                                    <td  bgcolor="#d3d3d3" colspan="6">{{moneyFormat($inventory->total)}}</td>
                                </tr>
                                <tr style="text-align: center">
                                    <td>Inventory Provision</td>
                                    <td colspan="6" style="color: red"><span class="text-danger">({{moneyFormat($inventory->inventory_provision)}})</span></td>
                                </tr>
                                <tr style="text-align: center">
                                    <td>Net Realizable Value</td>
                                    <td  bgcolor="#d3d3d3" colspan="6">{{moneyFormat($inventory->inventory_provision + $inventory->total)}}</td>
                                </tr>
                            @else
                           <tr style="text-align: center">
                               <td colspan="7">No available data</td>
                           </tr>
                            @endif
                           </tbody>
                       </table>

                   </table>
            @endif

            </div>

            @if($showReport)
                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-light-success font-weight-bold" id="exportToExcelBtn">
                                Export To Excel
                            </button>
                            <button type="button" class="btn btn-primary font-weight-bold"  onclick="window.print();">Print
                                Report
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            <!-- end: Invoice action-->
            <!-- end: Invoice-->
        </div>
    </div>
@endsection

@section('styles')
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }

    </style>
@endsection
{{-- Scripts Section --}}
@section('scripts')
    <script>
        jQuery(document).ready(function () {
            $('#kt_datepicker_1').datepicker({
                orientation: "bottom left",
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
                // startDate: new Date(),
                // endDate: new Date(),
                autoclose: true,

            });


            $("#exportToExcelBtn").on("click", function(e){
                e.preventDefault();
                toExcel();

            })




        });



        function toExcel() {
            const mainTable = document.getElementById("tableToExport");
            const companyInfoTable = document.getElementById("companyInfoTable");
            const salesResultTable = document.getElementById("salesResultTable");
            const cumResultTable = document.getElementById("cumResultTable");
            const debitTable = document.getElementById("debitTable");
            const inventory = document.getElementById("inventory");

            companyInfoTable.style.border = '1px solid black';
            salesResultTable.style.border = '1px solid black';
            cumResultTable.style.border = '1px solid black';
            debitTable.style.border = '1px solid black';
            inventory.style.border = '1px solid black';


            const mainTableOuter = mainTable.outerHTML + '<br />';
            const companyInfoTableOuter = companyInfoTable.outerHTML + '<br />';
            const salesResultTableOuter = salesResultTable.outerHTML + '<br />';
            const cumResultTableOuter = cumResultTable.outerHTML + '<br />';
            const debitTableOuter = debitTable.outerHTML + '<br />';
            const inventoryOuter = inventory.outerHTML + '<br />';

            let tab_text = mainTableOuter+companyInfoTableOuter+salesResultTableOuter+cumResultTableOuter+debitTableOuter+inventoryOuter;


            let a = document.createElement('a');
            let data_type = 'data:application/vnd.ms-excel';
            a.href = data_type+','+encodeURIComponent(tab_text);
            // sa = window.open('data:application/vnd.ms-excel;,' + encodeURIComponent(tab_text)+';filename=summary-report-'+(new Date()).toDateString());
            a.download = `summary-report-{{getFormatSummaryReportDate(request('date'))}}`;
            //triggering the function
            a.click();

            companyInfoTable.style.border = '';
            salesResultTable.style.border = '';
            cumResultTable.style.border = '';
            debitTable.style.border = '';
            inventory.style.border = '';
        }

    </script>


@endsection
