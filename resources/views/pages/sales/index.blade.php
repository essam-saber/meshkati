{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
											<span class="card-icon">
												<i class="flaticon2-layers text-primary"></i>
											</span>
                <h3 class="card-label">Monthly Sales</h3>
            </div>
            <div class="card-toolbar">
                <!--end::Dropdown-->
                <!--begin::Button-->
                <a href="{{route('sales.create')}}" class="btn btn-primary font-weight-bolder">
                    <i class="la la-plus"></i>New Record</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                <thead>
                <tr >
                    <th>Year</th>
                    <th>Month</th>
                    <th>Credit</th>
                    <th>Cash</th>
                    <th>Total</th>
                    <th>Returns</th>
                    <th>Net</th>
                    <th>Cost of Sales</th>
                    <th>Expenses</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td>{{$sale->year}}</td>
                        <td>{{$sale->monthName}}</td>
                        <td>{{moneyFormat($sale->credit)}}</td>
                        <td>{{moneyFormat($sale->cash)}}</td>
                        <td>{{moneyFormat($sale->total)}}</td>
                        <td>{{moneyFormat($sale->returns)}}</td>
                        <td>{{moneyFormat($sale->net_sales)}}</td>
                        <td>{{moneyFormat($sale->cost_of_sales)}}</td>
                        <td>{{moneyFormat($sale->expenses)}}</td>
                        <td>
                            <a href="{{route('sales.edit', $sale->id)}}" class="btn btn-xs btn-info p-2 pl-3"><i class="fa fa-pen"></i></a>
                            <a  href="#" data-sale-id="{{$sale->id}}" class="delete-sale btn btn-xs btn-danger p-2 pl-3"><i class="fa fa-trash"></i></a>

                            <form style="display: none" method="post" action="{{route('sales.destroy', $sale->id)}}" id="delete-form-{{$sale->id}}">
                                @csrf()
                                @method('delete')

                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->
    <!--begin::Card-->

    <!--end::Card-->
@endsection
@section('styles')

    <style>
        .footer{
            position: absolute;
            bottom: 0;
            width: 82.5%;
            height: 3.5rem;
        }
    </style>
@endsection
{{-- Scripts Section --}}
@section('scripts')
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>

{{--    <script src="{{asset('js/pages/crud/datatables/basic/paginations.js')}}"></script>--}}

    <script>
        $(".delete-sale").on("click", function(){
           const saleId = $(this).data('sale-id');
           if(confirm('Are you sure?!')) {
               $(`#delete-form-${saleId}`).submit();
           }
        })
        var table = $('#kt_datatable');

        // begin first table
        table.DataTable({
            responsive: true,
            pagingType: 'full_numbers',

        });

        $(function(){
            $('.sorting_asc').addClass('sorting_desc');
        });
    </script>

    @if(session()->has('success'))
        <script>

            Swal.fire("Success!", "{!! session()->get('success') !!}", "success");

        </script>
    @endif
@endsection
