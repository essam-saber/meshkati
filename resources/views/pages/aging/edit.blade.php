{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Create aging of debit</h3>

        </div>
    @php
        [$year, $month] = explode('-', $date);
    @endphp
        <!--begin::Form-->
        <form class="form" method="post" action="{{route('aging-of-debit.update', [$year, $month])}}">
            @csrf()
            @method('put');
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-3 col-sm-12">Select Month </label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group date">
                            <input value="{{$date}}" type="text" class="form-control {{$errors->has('month') ? 'is-invalid': ''}}" name="month" required id="kt_datepicker_1" readonly="readonly" placeholder="Select date">
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
                @foreach($attributes as $attribute)
                    <div class="form-group row">
                        <label class="col-form-label text-left col-lg-3 col-sm-12">{{$attribute->name}}</label>
                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <div class="input-group">
                                <input type="number" required name="attributes[{{$attribute->id}}]" min="0" value="{{$agings[$attribute->id][0]->value}}" step=".01" class="form-control" aria-label="Amount (to the nearest SAR)">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">SAR</span>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach




            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9 ml-lg-auto">
                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                        <a href="{{route('aging-of-debit.index')}}" class="btn btn-secondary">Back</a>
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
