{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Insert goods state into the inventory</h3>

        </div>
        <!--begin::Form-->
        <form class="form" method="post" action="{{route('inventory.store')}}">
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
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Goods Ready For Sale</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group">
                            <input type="number" required name="goods_ready_for_sale" min="0" value="0" step=".01" class="form-control" aria-label="Amount (to the nearest SAR)">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            @if($errors->has('goods_ready_for_sale'))
                                <div class="invalid-feedback">{{$errors->first('goods_ready_for_sale')}}</div>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Finished Products</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group">
                            <input type="number" required name="finished_products" min="0" value="0" step=".01" class="form-control" aria-label="Amount (to the nearest SAR)">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            @if($errors->has('finished_products'))
                                <div class="invalid-feedback">{{$errors->first('finished_products')}}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Semi-Finished Products</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group">
                            <input type="number" required name="semi_finished_products" min="0" value="0" step=".01" class="form-control" aria-label="Amount (to the nearest SAR)">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            @if($errors->has('semi_finished_products'))
                                <div class="invalid-feedback">{{$errors->first('semi_finished_products')}}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Work In Process</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group">
                            <input type="number" required name="work_in_process" min="0" value="0" step=".01" class="form-control" aria-label="Amount (to the nearest SAR)">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            @if($errors->has('work_in_process'))
                                <div class="invalid-feedback">{{$errors->first('work_in_process')}}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Raw Materials</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group">
                            <input type="number" required name="raw_materials" min="0" value="0" step=".01" class="form-control" aria-label="Amount (to the nearest SAR)">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            @if($errors->has('raw_materials'))
                                <div class="invalid-feedback">{{$errors->first('raw_materials')}}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Spare Parts & Others</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group">
                            <input type="number" required name="spare_parts_and_others" min="0" value="0" step=".01" class="form-control" aria-label="Amount (to the nearest SAR)">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            @if($errors->has('spare_parts_and_others'))
                                <div class="invalid-feedback">{{$errors->first('spare_parts_and_others')}}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Inventory Provision</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group">
                            <input type="number" required name="inventory_provision" min="0" value="0" step=".01" class="form-control" aria-label="Amount (to the nearest SAR)">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            @if($errors->has('inventory_provision'))
                                <div class="invalid-feedback">{{$errors->first('inventory_provision')}}</div>
                            @endif
                        </div>
                    </div>
                </div>


            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9 ml-lg-auto">
                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                        <a href="#" class="btn btn-secondary">Back</a>
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
