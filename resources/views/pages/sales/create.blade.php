{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Insert the sales info for this month</h3>

        </div>
        <!--begin::Form-->
        <form class="form" method="post" action="{{route('sales.store')}}">
            @csrf()
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Select Month </label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                     <div class="input-group date">
                         <input  type="text" class="form-control {{$errors->has('month') ? 'is-invalid': ''}}" name="month" required id="kt_datepicker_1" readonly="readonly" placeholder="Select date">
                         <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
                         </div>
                         @if($errors->has('month'))
                             <div class="invalid-feedback">{{$errors->first('month')}}</div>
                         @endif
                     </div>

                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Cash</label>

                    <div class="col-lg-4 col-md-9 col-sm-12">
                    <div class="input-group">
                        <input id="cash" type="number" required name="cash" min="0" value="0" step=".01" class="{{$errors->has('cash') ? 'is-invalid': ''}} form-control" aria-label="Amount (to the nearest SAR)">

                        <div class="input-group-prepend">
                            <span class="input-group-text">SAR</span>

                        </div>
                        @if($errors->has('cash'))
                            <div class="invalid-feedback">{{$errors->first('cash')}}</div>
                        @endif
                    </div>
                    </div>


                </div>
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Credit</label>

                    <div class="col-lg-4 col-md-9 col-sm-12">
                       <div class="input-group">
                           <input id="credit" type="number" required name="credit" min="0" value="0" step=".01" class="form-control {{$errors->has('credit') ? 'is-invalid': ''}} " aria-label="Amount (to the nearest SAR)">
                           <div class="input-group-prepend">
                               <span class="input-group-text">SAR</span>

                           </div>
                           @if($errors->has('credit'))
                               <div class="invalid-feedback">{{$errors->first('credit')}}</div>
                           @endif
                       </div>


                    </div>


                </div>
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Total</label>

                    <div class="col-lg-4 col-md-9 col-sm-12">
                       <div class="input-group">
                           <input id="total" required name="total" readonly type="text" class="form-control {{$errors->has('total') ? 'is-invalid': ''}}" aria-label="Amount (to the nearest SAR)">
                           <div class="input-group-prepend">
                               <span class="input-group-text">SAR</span>

                           </div>
                           @if($errors->has('total'))
                               <div class="invalid-feedback">{{$errors->first('total')}}</div>
                           @endif
                       </div>
                    </div>


                </div>
                <div class="form-group row ">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Returns</label>

                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group">
                            <input id="returns" type="number" required name="returns" min="0" value="0" step=".01"  class="form-control border-warning {{$errors->has('returns') ? 'is-invalid': ''}}" aria-label="Amount (to the nearest SAR)">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>

                            </div>
                            @if($errors->has('returns'))
                                <div class="invalid-feedback">{{$errors->first('returns')}}</div>
                            @endif
                        </div>
                    </div>


                </div>

                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Net</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                     <div class="input-group">
                         <input type="text" required readonly name="net" id="net" class="form-control {{$errors->has('total') ? 'is-invalid': ''}}" aria-label="Amount (to the nearest SAR)">
                         <div class="input-group-prepend">
                             <span class="input-group-text">SAR</span>

                         </div>
                         @if($errors->has('net'))
                             <div class="invalid-feedback">{{$errors->first('net')}}</div>
                         @endif
                     </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Cost Of Sales</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group">
                            <input id="cost_of_sales" type="number" required name="cost_of_sales" min="0" value="0" step=".01" class="{{$errors->has('cost_of_sales') ? 'is-invalid': ''}} form-control" aria-label="Amount (to the nearest SAR)">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            @if($errors->has('cost_of_sales'))
                                <div class="invalid-feedback">{{$errors->first('cost_of_sales')}}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Expenses</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group">
                            <input id="expenses" type="number" required name="expenses" min="0" value="0" step=".01" class="{{$errors->has('expenses') ? 'is-invalid': ''}} form-control" aria-label="Amount (to the nearest SAR)">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            @if($errors->has('expenses'))
                                <div class="invalid-feedback">{{$errors->first('expenses')}}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9 ml-lg-auto">
                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                        <a href="{{route('sales.index')}}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card-->

@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>

    <script>
        const numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;

        let total = 0;
        let cash = 0;
        let credit = 0;
        let returns = 0;
        let net = 0;

        $("#cash").on('input', function(e){
             cash = Number($(this).val());
             total = cash + credit;
             net = total;
            $("#total").val(total);
            $("#net").val(net);

        });

        $("#credit").on('input', function(e){
            credit = Number($(this).val());
            total = cash + credit;
            net = total;
            $("#total").val(total);
            $("#net").val(net);

        });

        $("#returns").on('input', function(e){
            returns = Number($(this).val());
            net = total - returns;
            $("#net").val(net);
        });

        jQuery(document).ready(function() {
            $('#kt_datepicker_1').datepicker({
                orientation: "bottom left",
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
                // startDate: new Date(),
                // endDate: new Date(),
                autoclose: true,

            });



        });
    </script>

    @if(session()->has('success'))
        <script>
            Swal.fire("Success!", "{!! session()->get('success') !!}", "success");

        </script>

    @endif
    @if(session()->has('error'))
        <script>
            Swal.fire("Error!", "{!! session()->get('error') !!}", "error");

        </script>

    @endif
@endsection
