{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Edit role</h3>

                </div>
                <form class="form" method="post" action="{{route('roles.update', $role->id)}}">
                    @csrf()
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Role Name:</label>
                            <input type="text" class="form-control form-control-solid {{$errors->has('name') ? 'is-invalid': ''}}" name="name" value="{{$role->name}}"/>
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
                                                @php
                                                    $permissionName = ucwords(str_replace('_', ' ', $v));
                                                @endphp
                                                <label class="checkbox">
                                                    <input value="{{$v}}" name="permissions[]" type="checkbox" {{$rolePermissions->contains($v) ? 'checked': ''}}>
                                                    <span></span>{{$permissionName}}</label>
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
