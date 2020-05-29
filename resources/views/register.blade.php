<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Twitter -->
        <meta name="twitter:site" content="@themepixels">
        <meta name="twitter:creator" content="@themepixels">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Bracket">
        <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
        <meta name="twitter:image" content="../../../../themepixels.me/bracket/img/bracket-social.html">

        <!-- Facebook -->
        <meta property="og:url" content="http://themepixels.me/bracket">
        <meta property="og:title" content="Bracket">
        <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

        <meta property="og:image" content="../../../../themepixels.me/bracket/img/bracket-social.html">
        <meta property="og:image:secure_url" content="../../../../themepixels.me/bracket/img/bracket-social.html">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="600">

        <!-- Meta -->
        <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
        <meta name="author" content="ThemePixels">

        <title>Axis Cheque & MR</title>
        <link rel="icon" href="{{asset('img/favicon.png')}}">

        <!-- vendor css -->
        <link href="{{asset('lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
        <link href="{{asset('lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">

        <!-- Bracket CSS -->
        <link rel="stylesheet" href="{{asset('css/bracket.css')}}">
    </head>

    <body>

        <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

            <div class="login-wrapper wd-400 wd-xs-400 pd-10 pd-xs-20 bg-white rounded shadow-base">

                <form action="{{ url('company-register') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if(session()->has('message'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                      {{ session()->get('message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif

                    <div class="row mg-b-10" style="margin-top:20px !important">
                        <div class="col-md-12">
                            @if(isset($info) && $info->logo != "")
                                <img class="pointer" id="logo" src="{{ asset('storage/'.$info->logo) }}" width="120" alt="logo" onclick="document.getElementById('imgInp').click()"/>
                            @else
                                <img class="pointer" id="logo" src="{{ asset('img/logo-placeholder.png') }}" width="120" alt="logo" onclick="document.getElementById('imgInp').click()"/>
                            @endif
                            <input class="collapse" type="file" name="logo" id="imgInp" onchange="preview_image(event)" />
                        </div>
                    </div>

                    <div class="row mg-b-10">
                        <div class="col-md-12">
                            <input id="name" type="text" name="name" placeholder="Company Name" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mg-b-10">
                            <input id="email" type="text" name="email" placeholder="Email Address" class="form-control">
                        </div>

                        <div class="col-md-6 mg-b-10">
                            <input id="phone" type="text" name="phone" placeholder="Phone Number" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mg-b-10">
                            <input id="tin" type="text" name="tin" placeholder="Tin Number" class="form-control">
                        </div>

                        <div class="col-md-6 mg-b-10">
                            <input id="vat_reg_no" type="text" name="vat_reg_no" placeholder="Vat Reg. No:" class="form-control">
                        </div>
                    </div>

                    <div class="row mg-b-10">
                        <div class="col-md-12">
                            <textarea id="address" type="text" name="address" placeholder="Address" class="form-control"></textarea>
                        </div>
                    </div>

                    <br>
                    <div class="row mg-b-10">
                        <div class="col-md-12">
                            <input id="login-email" type="text" name="login_email" placeholder="Login Email" class="form-control">
                        </div>
                    </div>

                    <div class="row mg-b-10">
                        <div class="col-md-12">
                            <input id="login-password" type="text" name="login_password" placeholder="Login Password" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info btn-block pointer">Sign In</button>

                </form>

                <div class="mg-t-30 tx-center tx-13 tx-uppercase tx-semibold tx-spacing-1">AXIS CHEQUE & MR</a></div>
            </div><!-- login-wrapper -->
        </div><!-- d-flex -->

            <script>
                function preview_image(event) {
                var reader = new FileReader();
                reader.onload = function()
                {
                    var output = document.getElementById('logo');
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
                }
            </script>

            <script src="{{asset('lib/jquery/jquery.js')}}"></script>
            <script src="{{asset('lib/popper.js/popper.js')}}"></script>
            <script src="{{asset('lib/bootstrap/bootstrap.js')}}"></script>

    </body>

</html>
