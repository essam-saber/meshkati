{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom overflow-hidden">
        <div class="flex-row-fluid ml-lg-12">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header py-3">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label font-weight-bolder text-dark">Account Information</h3>
                        <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account settings</span>
                    </div>

                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form class="form" method="POST" action="{{url('profile')}}">
                    @csrf()
                    <div class="card-body">
                        <!--begin::Heading-->
                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h5 class="font-weight-bold mb-6">Account:</h5>
                            </div>
                        </div>
                        <!--begin::Form Group-->
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Username</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="spinner spinner-sm spinner-success spinner-right">
                                    <input class="form-control form-control-lg form-control-solid" name="name" type="text" value="{{$user->name}}">
                                </div>
                            </div>
                        </div>
                        <!--begin::Form Group-->
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group input-group-lg input-group-solid">
                                    <div class="input-group-prepend">
																	<span class="input-group-text">
																		<i class="la la-at"></i>
																	</span>
                                    </div>
                                    <input type="text" name="email" class="form-control form-control-lg form-control-solid" value="{{$user->email}}" placeholder="Email">
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Old Password</label>
                            <div class="col-lg-9 col-xl-6">
                                <input class="form-control form-control-lg form-control-solid" name="old_password" type="password">
                                <span class="form-text text-muted">
															Please leave the old password empty if you're not going to change your password.</span>
                                @if($errors->has('old_password'))
                                    <div class="text-danger">{{$errors->first('old_password')}}</div>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
                            <div class="col-lg-9 col-xl-6">
                                <input name="password" class="form-control form-control-lg form-control-solid" type="password">
                                @if($errors->has('password'))
                                    <div class="text-danger">{{$errors->first('password')}}</div>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Repeat New Password</label>
                            <div class="col-lg-9 col-xl-6">
                                <input name="password_confirmation" class="form-control form-control-lg form-control-solid" type="password">
                                @if($errors->has('password'))
                                    <div class="text-danger">{{$errors->first('password')}}</div>
                                @endif
                            </div>

                        </div>
                        <div class="card-toolbar">
                            <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
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



    @if(session()->has('success'))
        <script>

            Swal.fire("Success!", "{!! session()->get('success') !!}", "success");

        </script>
    @endif
@endsection
