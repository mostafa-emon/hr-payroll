<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>AXIS HR & PAYROLL</title>
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
                        Invalid email or password!
                    </div>
                @enderror
                
                @error('password')
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Invalid email or password!
                    </div>
                @enderror
                @if(session()->has('error_message'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session()->get('error_message') }}
                    </div>
                @endif

                <form action="{{ url('auth/login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="email" placeholder="Enter your Email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    
                    <div class="form-group">
                        <input id="password" type="password" placeholder="Enter your password" class="form-control" name="password" value="{{ old('password') }}" required autocomplete="current-password">
                        <a href="{{ route('password.request') }}" style="margin-top: 15px;" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-info btn-block pointer">Sign In</button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                        </a>
                    @endif
                </form>

                <div class="mg-t-35 tx-center tx-10 tx-uppercase tx-semibold tx-spacing-1">AXIS HR & PAYROLL</a></div>
            </div><!-- login-wrapper -->
        </div><!-- d-flex -->

            <script src="{{asset('signin_page/jquery/jquery.js')}}"></script>
            <script src="{{asset('signin_page/popper.js/popper.js')}}"></script>
            <script src="{{asset('signin_page/bootstrap/bootstrap.js')}}"></script>

    </body>

</html>
