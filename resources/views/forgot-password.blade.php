@extends('layout.master_layout')
@section('page')



    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>


            {{-- @if (session::has('success'))
                <div class="alart alert-success">
                    <p class="mb-0 pb-0">{{ session::get('success') }}</p>
                </div>
            @endif --}}

             {{-- @if (session::has('error'))
                <div class="alart alert-danger">
                    <p class="mb-0 pb-0">{{ session::get('error') }}</p>
                </div>
            @endif --}}

            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Forgot Password</h1>
                        <form action="{{ route('authenticate') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                    placeholder="example@example.com">
                                @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="otp" class="mb-2">OTP*</label>
                                <input type="text" name="otp" id="otp" class="form-control @error('otp') is-invalid @enderror"
                                    placeholder="Enter OTP">
                                @error('otp')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="mb-2">New Password*</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter New Password">
                                @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror"
                                    placeholder="Confirm New Password">
                                @error('confirm_password')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="justify-content-between d-flex">
                                <button class="btn btn-primary mt-2" type="submit">Reset Password</button>
                                <a href="forgot-password.html" class="mt-3">Forgot Password?</a>
                            </div>
                            <div class="row">
                                <div class="mb-4 col-md-12">
                                    <label for="" class="mb-2">Salary</label>
                                    <div class="d-flex">
                                        <input type="number" placeholder="Salary" id="salary" name="salary" class="form-control me-2" style="flex: 8;">
                                        <select name="salary_unit" id="salary_unit" class="form-control" style="flex: 2;">
                                            <option value="monthly">Monthly</option>
                                            <option value="yearly">Yearly</option>
                                            <option value="hourly">Hourly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="mt-4 text-center">
                        <p>Do not have an account? <a href={{ url('/login') }}>Login</a></p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>

@endsection
