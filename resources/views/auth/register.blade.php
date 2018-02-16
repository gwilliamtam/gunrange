@extends('layouts.app')

@section('content')
<div class="container main-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Register</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">

                                    <button class="btn btn-outline-dark" id="accept-terms">Accept Terms and Conditions</button><br>
                                    <small class="text-muted">Click to read the Terms and Conditions.</small>
                                </div>
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="submit-button" class="btn btn-dark disabled">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('public.terms')

<script>
    function acceptTerms()
    {
        $("#accept-terms").removeClass("btn-outline-dark")
        $("#accept-terms").addClass("btn-dark")
        $("#accept-terms").html("Terms and Conditions Accepted")
        $("#submit-button").removeClass("disabled")
        $("#terms-modal").modal("hide")
    }

    function reverseAcceptTerms()
    {
        $("#accept-terms").removeClass("btn-dark")
        $("#accept-terms").addClass("btn-outline-dark")
        $("#accept-terms").html("Accept Terms and Conditions")
        $("#submit-button").addClass("disabled")
        $("#terms-modal").modal("hide")
    }

    $(document).ready(function(){
        $("#accept-terms").on("click", function(){
            $("#terms-modal").modal("show")
        })

        $("#accept-terms-button").on("click", function(){
            acceptTerms()
        })

        $("#no-accept-terms-button").on("click", function(){
            reverseAcceptTerms()
        })
    })
</script>
@endsection
