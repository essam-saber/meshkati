{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <!--begin::Card-->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Create new employee</h3>

                </div>
                <form class="form" method="post" action="{{route('employees.store')}}">
                    @csrf()
                    <div class="card-body">
                        <div class="form-group">
                            <label>Employee Name:</label>
                            <input type="text" class="form-control form-control-solid {{$errors->has('name') ? 'is-invalid': ''}}" name="name" placeholder="Enter employee name"/>
                            @if($errors->has('name'))
                                <div class="text-danger">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Employee Role:</label>
                            <select name="role" id="" class="form-control">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{ucwords(str_replace('_',' ', $role->name))}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Employee Email:</label>
                            <input type="email" class="form-control form-control-solid {{$errors->has('email') ? 'is-invalid': ''}}" name="email" placeholder="Enter employee name"/>
                            @if($errors->has('email'))
                                <div class="text-danger">{{$errors->first('email')}}</div>
                            @endif
                        </div>
                        <small class="text-danger">Please be sure to enter the email correctly because the account password will be sent to it.</small>

                    </div>
                    <div class="card-footer">
                        <a href="{{route('employees.index')}}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>

                    </div>
                </form>
            </div>

        </div>

    </div>
    <!--end::Card-->

@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>

    <script>


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
