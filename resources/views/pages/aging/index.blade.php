{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom overflow-hidden">
        <div class="card-header">
            <div class="card-title">
											<span class="card-icon">
												<i class="flaticon2-layers text-primary"></i>
											</span>
                <h3 class="card-label">Aging of Debit</h3>
            </div>
            <div class="card-toolbar">
                <!--end::Dropdown-->
                <!--begin::Button-->
                <a href="{{route('aging-of-debit.create')}}" class="btn btn-primary font-weight-bolder">
                    <i class="la la-plus"></i>New Record</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    @foreach($attributes as $attribute)
                    <th>{{$attribute->name}}</th>
                    @endforeach
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($agingDebits as $key => $values)
                    @php
                    [$year, $month] = explode('-', $key);
                    @endphp
                     <tr>
                        <td>{{$year}}</td>
                        <td>{{$month}}</td>
                        @foreach($values as $value)
                            <td>{{ moneyFormat($value->value) }}</td>
                        @endforeach
                        <td>
                            <a href="{{route('aging-of-debit.edit', [$year, $month])}}" class="btn btn-xs btn-info p-2 pl-3"><i class="fa fa-pen"></i></a>
                            <a  href="#" data-sale-id="{{$value->id}}" class="delete-sale btn btn-xs btn-danger p-2 pl-3"><i class="fa fa-trash"></i></a>

                            <form style="display: none" method="post" action="{{route('aging-of-debit.destroy',  [$year, $month])}}" id="delete-form-{{$value->id}}">
                                @csrf()
                                @method('delete')

                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
            </div>


        </div>
    </div>

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
