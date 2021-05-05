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
                    <h3 class="card-title">Insert a new role</h3>

                </div>
                <form class="form" method="post" action="{{route('roles.store')}}">
                    @csrf()
                    <div class="card-body">
                        <div class="form-group">
                            <label>Role Name:</label>
                            <input type="text" class="form-control form-control-solid {{$errors->has('name') ? 'is-invalid': ''}}" name="name" placeholder="Enter role name"/>
                            <span class="form-text text-muted">Please enter the role name</span>
                            @if($errors->has('name'))
                                <div class="text-danger">{{$errors->first('name')}}</div>
                            @endif
                        </div>

                        <h6>Choose role permissions</h6>
                        <ul class="nav nav-tabs nav-tabs-line">

                         @foreach($permissions as $key => $value)

                                <li class="nav-item">
                                    <a class="nav-link {{$loop->iteration === 1 ? 'active': ''}}" data-toggle="tab" href="#{{$key}}">{{ucwords(str_replace('_', ' ', $key))}}</a>
                                </li>
                         @endforeach
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            @foreach($permissions as $key => $value)
                                <div class="tab-pane fade {{$loop->iteration === 1 ? 'show active': ''}}" id="{{$key}}" role="tabpanel" aria-labelledby="{{$key}}">
                                    <div class="form-group">
                                        <div class="checkbox-list">

                                            @foreach($value as $v)
                                                <label class="checkbox">
                                                    <input value="{{$v}}" name="permissions[]" type="checkbox">
                                                    <span></span>{{ucwords(str_replace('_', ' ', $v))}}</label>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>

                            @endforeach
                                @if($errors->has('permissions'))
                                    <div class="text-danger">{{$errors->first('permissions')}}</div>
                                @endif
                        </div>

                    </div>
                    <div class="card-footer">
                        <a href="{{route('roles.index')}}" class="btn btn-secondary">Back</a>
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
