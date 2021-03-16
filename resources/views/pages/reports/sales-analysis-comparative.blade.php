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
                                       <input  type="text" class="form-control {{$errors->has('first_date') ? 'is-invalid': ''}}" name="first_date" required id="kt_datepicker_1" readonly="readonly" placeholder="Select a year">
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
                                       <input  type="text" class="form-control {{$errors->has('second_date') ? 'is-invalid': ''}}" name="second_date" required id="kt_datepicker_2" readonly="readonly" placeholder="with a year">
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
            <div class="row justify-content-center" id="">
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
                            <span class="font-weight-bolder mb-2">DATE START</span>
                            <span class="opacity-70">{{$secondYear}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">DATE END</span>
                            <span class="opacity-70">{{$firstYear}}</span>
                        </div>
                        <div class="d-flex flex-column flex-root">
                            <span class="font-weight-bolder mb-2">Monthly Sales & Sales Return</span>
                            <span class="opacity-70">
														<br>This Report Contains Sales Analysis & Comparison</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Invoice header-->
            <!-- begin: Invoice body-->
            <div class="row p-5" id="tables">


                @if(sizeof($secondYearSales))
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <p class="text-center"><strong>{{$secondYear}}</strong></p>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr bgcolor="#d3d3d3">
                                        <th>{{$secondYear}}</th>
                                        <th>Cash </th>
                                        <th>Credit </th>
                                        <th>Total</th>
                                        <th class="text-danger">Returns</th>
                                        <th>Net</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($secondYearSales as $sale)
                                        <tr>
                                            <td>{{\Carbon\Carbon::parse($sale->year."-".$sale->month)->monthName}}</td>
                                            <td>{{$sale->cash}}</td>
                                            <td>{{$sale->credit}}</td>
                                            <td>{{$sale->total}}</td>
                                            <td class="text-danger">{{$sale->returns}}</td>
                                            <td>{{$sale->net_sales}}</td>
                                        </tr>
                                    @endforeach
                                    <tr bgcolor="#d3d3d3">
                                        <th>TOTAL</th>
                                        <th>{{$secondYearSales->sum('cash')}}</th>
                                        <th>{{$secondYearSales->sum('credit')}}</th>
                                        <th>{{$secondYearSales->sum('total')}}</th>
                                        <th class="text-danger">{{$secondYearSales->sum('returns')}}</th>
                                        <th>{{$secondYearSales->sum('net_sales')}}</th>
                                    </tr>
                                    <tr bgcolor="#d3d3d3">
                                        <th>%</th>
                                        <th>{{round(($secondYearSales->sum('cash') / $secondYearSales->sum('total')) * 100,2)}}%</th>
                                        <th>{{round(($secondYearSales->sum('credit') / $secondYearSales->sum('total')) * 100,2)}}%</th>
                                        <th>100%</th>
                                        <th class="text-danger">{{round(($secondYearSales->sum('returns') / $secondYearSales->sum('total')) * 100,2)}}%</th>
                                        <th></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                @endif

                @if(sizeof($firstYearSales))
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <p class="text-center"><strong>{{$firstYear}}</strong></p>
                                <table class="table table-bordered" id="">
                                    <thead>
                                    <tr bgcolor="#d3d3d3">
                                        <th>{{$firstYear}}</th>
                                        <th>Cash</th>
                                        <th>Credit</th>
                                        <th>Total</th>
                                        <th class="text-danger">Returns</th>
                                        <th>Net</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($firstYearSales as $sale)
                                        <tr>
                                            <td>{{\Carbon\Carbon::parse($sale->year."-".$sale->month)->monthName}}</td>
                                            <td>{{$sale->cash}}</td>
                                            <td>{{$sale->credit}}</td>
                                            <td>{{$sale->total}}</td>
                                            <td class="text-danger">{{$sale->returns}}</td>
                                            <td>{{$sale->net_sales}}</td>
                                        </tr>
                                    @endforeach
                                    <tr bgcolor="#d3d3d3">
                                        <th>TOTAL</th>
                                        <th>{{$firstYearSales->sum('cash')}}</th>
                                        <th>{{$firstYearSales->sum('credit')}}</th>
                                        <th>{{$firstYearSales->sum('total')}}</th>
                                        <th class="text-danger">{{$firstYearSales->sum('returns')}}</th>
                                        <th>{{$firstYearSales->sum('net_sales')}}</th>
                                    </tr>
                                    <tr bgcolor="#d3d3d3">
                                        <th>%</th>
                                        <th>{{round(($firstYearSales->sum('cash') / $firstYearSales->sum('total')) * 100,0)}}%</th>
                                        <th>{{round(($firstYearSales->sum('credit') / $firstYearSales->sum('total')) * 100,0)}}%</th>
                                        <th>100%</th>
                                        <th class="text-danger">{{round(($firstYearSales->sum('returns') / $firstYearSales->sum('total')) * 100,0)}}%</th>
                                        <th></th>
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
                        <button type="button" class="btn btn-success font-weight-bold" id="exportBtn"><i class="fa fa-file-excel"></i>Export to Excel</button>
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
        jQuery(document).ready(function() {
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

            $(document).ready(function () {
                $("#exportBtn1").click(function(){
                    TableToExcel.convert(document.getElementById("tables"), {
                        name: `${(new Date()).toDateString()}.xlsx`,
                        sheet: {
                            name: "Sheet1"
                        }
                    });
                });
            });


        });
    </script>
@endsection
