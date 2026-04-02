<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>PayRoll</title>
        <link rel="icon" href="{{asset('assets/img/favicon.png')}}">

        <!-- vendor css -->
        <link href="{{asset('signin_page/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
        <link href="{{asset('signin_page/Ionicons/css/ionicons.css')}}" rel="stylesheet">

        <!-- Bracket CSS -->
        <link rel="stylesheet" href="{{asset('signin_page/css/bracket.css')}}">
    </head>

    <body>

        <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

            <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
                <div class="signin-logo mg-b-40 tx-center tx-28 tx-bold tx-inverse">
                    <img src="{{asset('assets/img/logo.png')}}" height="55"/>
                </div>
                
                @error('email')
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Invalid Email!
                    </div>
                @enderror

                @if (session('status'))
                    <div class="alert alert-info" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <input id="email" type="email" placeholder="Enter Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <a href="{{ url('login') }}" style="margin-top: 15px;" class="tx-info tx-12 d-block mg-t-10"> Back to Login? </a>
                    </div>

                    <button type="submit" class="btn btn-info btn-block pointer">Send Password Reset Link</button>
                </form>

                <div class="mg-t-35 tx-center tx-10 tx-uppercase tx-semibold tx-spacing-1">PayRoll</a></div>
            </div><!-- login-wrapper -->
        </div><!-- d-flex -->

            <script src="{{asset('signin_page/jquery/jquery.js')}}"></script>
            <script src="{{asset('signin_page/popper.js/popper.js')}}"></script>
            <script src="{{asset('signin_page/bootstrap/bootstrap.js')}}"></script>

    </body>

</html>
