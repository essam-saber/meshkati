{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <!--begin::Card-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Record sales expenses</h3>

        </div>
        <!--begin::Form-->
        <form class="form" method="post" action="{{route('sales.expenses.store')}}">
            @csrf()
            <div class="card-body">
                @foreach($sales as $sale)
                    <div class="form-group row">
                        <label class="col-form-label text-left col-lg-1 col-sm-1">Year</label>

                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <input id="total" value="{{$sale->year}}" name="total" disabled type="text" class="form-control" aria-label="Amount (to the nearest SAR)">
                        </div>
                        <label class="col-form-label text-left col-lg-1 col-sm-1">Month</label>

                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <input id="total" value="{{\Carbon\Carbon::parse($sale->year.'-'.$sale->month)->monthName}}" name="total" disabled type="text" class="form-control" aria-label="Amount (to the nearest SAR)">
                        </div>
                        <label class="col-form-label text-left col-lg-1 col-sm-1">Total</label>

                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <input id="total" value="{{$sale->total}}" name="total" disabled type="text" class="form-control" aria-label="Amount (to the nearest SAR)">
                        </div>

                        <label class="col-form-label text-left col-lg-1 col-sm-1">Expenses</label>

                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <input id="expenses" type="number" required min="0" step=".01"  value="{{$sale->expenses?? ''}}" name="profit[{{$sale->id}}]"  class="form-control" aria-label="Amount (to the nearest SAR)">
                        </div>

                    </div>
                @endforeach

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
