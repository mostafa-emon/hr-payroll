<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="X-UA-Compatible" content="IE=9" />

		<title> @if(!isset(app()->view->getSections()['title'])) AXIS HR & PAYROLL @else {{ app()->view->getSections()['title'] }} @endif </title>

		<link rel="icon" href="{{asset('assets/img/favicon.png')}}" type="image/x-icon"/>

		<link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
		<link href="{{asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet"/>
		<link href="{{asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
		<link href="{{asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
		<link rel="stylesheet" href="{{asset('assets/css/sidemenu.css')}}">
		<link href="{{asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/skin-modes.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
		<link href="{{asset('lib/datatables/jquery.dataTables.css')}}" rel="stylesheet">

	</head>

	<body class="main-body app sidebar-mini {{ leftmenu_color() }}">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<!-- main-sidebar -->
			<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
			<aside class="app-sidebar sidebar-scroll">
				<div class="main-sidebar-header active">
					<a class="desktop-logo logo-light active" href="{{url('/')}}"><img src="{{asset('assets/img/logo.png')}}" class="main-logo" alt="logo"></a>
					<a class="desktop-logo logo-dark active" href="{{url('/')}}"><img src="{{asset('assets/img/logo-light.png')}}" class="main-logo dark-theme" alt="logo"></a>
					<a class="logo-icon mobile-logo icon-light active" href="{{url('/')}}"><img src="{{asset('assets/img/logo.png')}}" class="logo-icon" alt="logo"></a>
					<a class="logo-icon mobile-logo icon-dark active" href="{{url('/')}}"><img src="{{asset('assets/img/logo-light.png')}}" class="logo-icon dark-theme" alt="logo"></a>
				</div>
				<div class="main-sidemenu">
					<div class="app-sidebar__user clearfix">
						<div class="dropdown user-pro-body">
							<div class="">
								@if(Auth::user()->avatar != "")
									<img src="{{asset('assets/img/users.png')}}" alt="user-img" class="avatar avatar-xl brround">
									{{--<img src="{{Config::get('app.admin_url').Auth::user()->avatar}}" alt="user-img" class="avatar avatar-xl brround" >--}}
								@else
									<img src="{{asset('assets/img/users.png')}}" alt="user-img" class="avatar avatar-xl brround">
								@endif
								<span class="avatar-status profile-status bg-green"></span>
							</div>
							<div class="user-info">
								<h4 class="font-weight-semibold mt-3 mb-0">{{ Auth::user()->name }}</h4>
								<span class="mb-0 text-muted">{{ Auth::user()->designation }}</span>
							</div>
						</div>
					</div>
                    <ul class="side-menu">
						@if(roles() != "" && in_array(100, json_decode(roles(),false)))
						<li class="side-item side-item-category">Admin</li>
						@else
						<li class="side-item side-item-category">Home</li>
						@endif

                        <li class="slide">
                            <a class="side-menu__item" href="{{url('/')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"></path><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"></path></svg>
                                <span class="side-menu__label">Dashboard</span>
                            </a>
                        </li>

						@if(roles() != "" && in_array(100, json_decode(roles(),false)))

						<li class="slide  {{ (request()->is('subscription*')) || (request()->is('company-register*')) ? 'active' : '' }}">
							<a class="side-menu__item {{ (request()->is('subscription*')) || (request()->is('company-register*')) ? 'active' : '' }}" href="{{url('/subscription')}}">
								<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 9h14V5H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5S7.83 8.5 7 8.5 5.5 7.83 5.5 7 6.17 5.5 7 5.5zM5 19h14v-4H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5z" opacity=".3"/><path d="M20 13H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1zm-1 6H5v-4h14v4zm-12-.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zM20 3H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zm-1 6H5V5h14v4zM7 8.5c.83 0 1.5-.67 1.5-1.5S7.83 5.5 7 5.5 5.5 6.17 5.5 7 6.17 8.5 7 8.5z"/></svg>
								<span class="side-menu__label">Subscription</span>
							</a>
						</li>

						@else
						<li class="side-item side-item-category">Master Setup</li>
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <svg class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/><path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg>
                                <span class="side-menu__label">Company Setup</span><i class="angle fe fe-chevron-down"></i>
                            </a>
                            
                            <ul class="slide-menu">
								<li><a class="slide-item" href="{{url('company')}}">Company</a></li>
								<li><a class="slide-item" href="{{url('departments')}}">Department</a></li>
								<li><a class="slide-item" href="{{url('designations')}}">Designation</a></li>
								<li><a class="slide-item" href="{{url('projects')}}">Project</a></li>
								<li><a class="slide-item" href="{{url('branches')}}">Branch</a></li>
								<li><a class="slide-item" href="{{url('currencies')}}">Currency</a></li>
								<li><a class="slide-item" href="{{url('bank-accounts')}}">Bank Account</a></li>
                            </ul>
						</li>
                        <li class="slide
                            {{ (request()->is('employee*')) ? 'is-expanded' : '' }}">
                            
                            <a class="side-menu__item {{ (request()->is('employee*')) ? 'active' : '' }}" data-toggle="slide" href="javascript:void(0)">
                                <svg class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/><path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg>
                                <span class="side-menu__label">Employee Setup</span><i class="angle fe fe-chevron-down"></i>
                            </a>
                            
                            <ul class="slide-menu">
								<li><a class="slide-item" href="{{url('employee')}}">Employee</a></li>
                            </ul>
                        </li>
						@endif
                        <br>
                    </ul>
				</div>
			</aside>
			<!-- main-sidebar -->

			<!-- main-content -->
			<div class="main-content app-content">

				<!-- main-header -->
				<div class="main-header sticky side-header nav nav-item">
					<div class="container-fluid">
						<div class="main-header-left ">
							<div class="responsive-logo">
								<a href="{{url('/')}}"><img src="{{asset('assets/img/logo.png')}}" class="logo-1" alt="logo"></a>
								<a href="{{url('/')}}"><img src="{{asset('assets/img/logo-light.png')}}" class="dark-logo-1" alt="logo"></a>
								<a href="{{url('/')}}"><img src="{{asset('assets/img/logo.png')}}" class="logo-2" alt="logo"></a>
								<a href="{{url('/')}}"><img src="{{asset('assets/img/logo-light.png')}}" class="dark-logo-2" alt="logo"></a>
							</div>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>
						</div>
						<div class="main-header-right">
							<div class="nav nav-item  navbar-nav-right ml-auto">
								<div class="nav-link" id="bs-example-navbar-collapse-1">
									<form class="navbar-form" role="search">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Search">
											<span class="input-group-btn">
												<button type="reset" class="btn btn-default">
													<i class="fas fa-times"></i>
												</button>
												<button type="submit" class="btn btn-default nav-link resp-btn">
													<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
												</button>
											</span>
										</div>
									</form>
								</div>
								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
									<a class="profile-user d-flex" href="">
										@if(Auth::user()->avatar != "")
											{{--<img src="{{Config::get('app.admin_url').Auth::user()->avatar}}" alt="">--}}
											<img src="{{asset('assets/img/users.png')}}" alt="">
										@else
											<img src="{{asset('assets/img/users.png')}}" alt="">
										@endif
									</a>
									<div class="dropdown-menu">
										<div class="main-header-profile bg-primary p-3">
											<div class="d-flex wd-100p">
												<div class="main-img-user">
													@if(Auth::user()->avatar != "")
														{{--<img src="{{Config::get('app.admin_url').Auth::user()->avatar}}" alt="" class="">--}}
														<img src="{{asset('assets/img/users.png')}}" alt="" class="">
													@else
														<img src="{{asset('assets/img/users.png')}}" alt="" class="">
													@endif
												</div>
												<div class="ml-3 my-auto">
													<h6>{{ Auth::user()->name }}</h6><span>{{ Auth::user()->designation }}</span>
												</div>
											</div>
										</div>
										<a class="dropdown-item" href="{{ url('user/profile/'.Auth::user()->id) }}"><i class="bx bx-cog"></i> Edit Profile</a>
										<a class="dropdown-item" href="{{url('logout')}}"><i class="bx bx-log-out"></i> Sign Out</a>
									</div>
								</div>
								<div class="dropdown main-header-message right-toggle">
									<a class="nav-link pr-0" data-toggle="sidebar-right" data-target=".sidebar-right">
										<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /main-header -->

				<!-- container -->
				<div class="container-fluid">
                    @yield('content')
                </div>
				<!-- /Container -->
			</div>
			<!-- /main-content -->

			<!-- Sidebar-right-->
			<div class="sidebar sidebar-right sidebar-animate">
				<div class="panel panel-primary card mb-0 box-shadow">
					<div class="tab-menu-heading border-0 p-3">
						<div class="card-title mb-0">Leftmenu Color</div>
						<div class="card-options ml-auto">
							<a href="#" class="sidebar-remove"><i class="fe fe-x"></i></a>
						</div>
					</div>
					<div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
						<div class="tabs-menu ">
							<!-- Tabs -->
							<ul class="nav panel-tabs">
								<li><a href="{{url('leftmenu-color/dark')}}" style="background-color: #081E3E; color:white"><i class="fa fa-palette tx-16 mr-2"></i> Dark</a></li>
								<li><a href="{{url('leftmenu-color/blue')}}" style="background-color: #0162E8; color:white"><i class="fa fa-palette tx-16 mr-2"></i> Blue</a></li>
								<li><a href="{{url('leftmenu-color/gradient')}}" style="background-color: #0687E4; color:white"><i class="fa fa-palette tx-16 mr-2"></i> Gradient</a></li>
								<li><a href="{{url('leftmenu-color/light')}}"><i class="fa fa-palette tx-16 mr-2"></i> Light</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!--/Sidebar-right-->

			<!-- Message Modal -->
			<div class="modal fade" id="chatmodel" tabindex="-1" role="dialog"  aria-hidden="true">
				<div class="modal-dialog modal-dialog-right chatbox" role="document">
					<div class="modal-content chat border-0">
						<div class="card overflow-hidden mb-0 border-0">
							<!-- action-header -->
							<div class="action-header clearfix">
								<div class="float-left hidden-xs d-flex ml-2">
									<div class="img_cont mr-3">
										<img src="{{asset('assets/img/faces/6.jpg')}}" class="rounded-circle user_img" alt="img">
									</div>
									<div class="align-items-center mt-2">
										<h4 class="text-white mb-0 font-weight-semibold">Daneil Scott</h4>
										<span class="dot-label bg-success"></span><span class="mr-3 text-white">online</span>
									</div>
								</div>
								<ul class="ah-actions actions align-items-center">
									<li class="call-icon">
										<a href="" class="d-done d-md-block phone-button" data-toggle="modal" data-target="#audiomodal">
											<i class="si si-phone"></i>
										</a>
									</li>
									<li class="video-icon">
										<a href="" class="d-done d-md-block phone-button" data-toggle="modal" data-target="#videomodal">
											<i class="si si-camrecorder"></i>
										</a>
									</li>
									<li class="dropdown">
										<a href="" data-toggle="dropdown" aria-expanded="true">
											<i class="si si-options-vertical"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><i class="fa fa-user-circle"></i> View profile</li>
											<li><i class="fa fa-users"></i>Add friends</li>
											<li><i class="fa fa-plus"></i> Add to group</li>
											<li><i class="fa fa-ban"></i> Block</li>
										</ul>
									</li>
									<li>
										<a href=""  class="" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true"><i class="si si-close text-white"></i></span>
										</a>
									</li>
								</ul>
							</div>
							<!-- action-header end -->

							<!-- msg_card_body -->
							<div class="card-body msg_card_body">
								<div class="chat-box-single-line">
									<abbr class="timestamp">February 1st, 2019</abbr>
								</div>
								<div class="d-flex justify-content-start">
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/6.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										Hi, how are you Jenna Side?
										<span class="msg_time">8:40 AM, Today</span>
									</div>
								</div>
								<div class="d-flex justify-content-end ">
									<div class="msg_cotainer_send">
										Hi Connor Paige i am good tnx how about you?
										<span class="msg_time_send">8:55 AM, Today</span>
									</div>
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/9.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
								</div>
								<div class="d-flex justify-content-start ">
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/6.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										I am good too, thank you for your chat template
										<span class="msg_time">9:00 AM, Today</span>
									</div>
								</div>
								<div class="d-flex justify-content-end ">
									<div class="msg_cotainer_send">
										You welcome Connor Paige
										<span class="msg_time_send">9:05 AM, Today</span>
									</div>
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/9.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
								</div>
								<div class="d-flex justify-content-start ">
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/6.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										Yo, Can you update Views?
										<span class="msg_time">9:07 AM, Today</span>
									</div>
								</div>
								<div class="d-flex justify-content-end mb-4">
									<div class="msg_cotainer_send">
										But I must explain to you how all this mistaken  born and I will give
										<span class="msg_time_send">9:10 AM, Today</span>
									</div>
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/9.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
								</div>
								<div class="d-flex justify-content-start ">
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/6.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										Yo, Can you update Views?
										<span class="msg_time">9:07 AM, Today</span>
									</div>
								</div>
								<div class="d-flex justify-content-end mb-4">
									<div class="msg_cotainer_send">
										But I must explain to you how all this mistaken  born and I will give
										<span class="msg_time_send">9:10 AM, Today</span>
									</div>
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/9.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
								</div>
								<div class="d-flex justify-content-start ">
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/6.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										Yo, Can you update Views?
										<span class="msg_time">9:07 AM, Today</span>
									</div>
								</div>
								<div class="d-flex justify-content-end mb-4">
									<div class="msg_cotainer_send">
										But I must explain to you how all this mistaken  born and I will give
										<span class="msg_time_send">9:10 AM, Today</span>
									</div>
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/9.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
								</div>
								<div class="d-flex justify-content-start">
									<div class="img_cont_msg">
										<img src="{{asset('assets/img/faces/6.jpg')}}" class="rounded-circle user_img_msg" alt="img">
									</div>
									<div class="msg_cotainer">
										Okay Bye, text you later..
										<span class="msg_time">9:12 AM, Today</span>
									</div>
								</div>
							</div>
							<!-- msg_card_body end -->
							<!-- card-footer -->
							<div class="card-footer">
								<div class="msb-reply d-flex">
									<div class="input-group">
										<input type="text" class="form-control " placeholder="Typing....">
										<div class="input-group-append ">
											<button type="button" class="btn btn-primary ">
												<i class="far fa-paper-plane" aria-hidden="true"></i>
											</button>
										</div>
									</div>
								</div>
							</div><!-- card-footer end -->
						</div>
					</div>
				</div>
			</div>

			<!--Video Modal -->
			<div id="videomodal" class="modal fade">
				<div class="modal-dialog" role="document">
					<div class="modal-content bg-dark border-0 text-white">
						<div class="modal-body mx-auto text-center p-7">
							<h5>Valex Video call</h5>
							<img src="{{asset('assets/img/faces/6.jpg')}}" class="rounded-circle user-img-circle h-8 w-8 mt-4 mb-3" alt="img">
							<h4 class="mb-1 font-weight-semibold">Daneil Scott</h4>
							<h6>Calling...</h6>
							<div class="mt-5">
								<div class="row">
									<div class="col-4">
										<a class="icon icon-shape rounded-circle mb-0 mr-3" href="#">
											<i class="fas fa-video-slash"></i>
										</a>
									</div>
									<div class="col-4">
										<a class="icon icon-shape rounded-circle text-white mb-0 mr-3" href="#" data-dismiss="modal" aria-label="Close">
											<i class="fas fa-phone bg-danger text-white"></i>
										</a>
									</div>
									<div class="col-4">
										<a class="icon icon-shape rounded-circle mb-0 mr-3" href="#">
											<i class="fas fa-microphone-slash"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Audio Modal -->
			<div id="audiomodal" class="modal fade">
				<div class="modal-dialog" role="document">
					<div class="modal-content border-0">
						<div class="modal-body mx-auto text-center p-7">
							<h5>Valex Voice call</h5>
							<img src="{{asset('assets/img/faces/6.jpg')}}" class="rounded-circle user-img-circle h-8 w-8 mt-4 mb-3" alt="img">
							<h4 class="mb-1  font-weight-semibold">Daneil Scott</h4>
							<h6>Calling...</h6>
							<div class="mt-5">
								<div class="row">
									<div class="col-4">
										<a class="icon icon-shape rounded-circle mb-0 mr-3" href="#">
											<i class="fas fa-volume-up bg-light"></i>
										</a>
									</div>
									<div class="col-4">
										<a class="icon icon-shape rounded-circle text-white mb-0 mr-3" href="#" data-dismiss="modal" aria-label="Close">
											<i class="fas fa-phone text-white bg-success"></i>
										</a>
									</div>
									<div class="col-4">
										<a class="icon icon-shape  rounded-circle mb-0 mr-3" href="#">
											<i class="fas fa-microphone-slash bg-light"></i>
										</a>
									</div>
								</div>
							</div>
						</div><!-- modal-body -->
					</div>
				</div><!-- modal-dialog -->
			</div><!-- modal -->

			<!-- Footer opened -->
			<div class="main-footer ht-40">
				<div class="container-fluid pd-t-0-f ht-100p">
					<span>Copyright © {{date('Y')}} <a href="#">&copy; {{ date('Y') }}. Axis QB & Voucher</a>. All rights reserved.</span>
				</div>
			</div>
			<!-- Footer closed -->

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

		<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
		<script src="{{asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
		<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('assets/plugins/ionicons/ionicons.js')}}"></script>
		<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
		<script src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
		<script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>

		<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

		<script src="{{asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
		<script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
		<script src="{{asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
		<script src="{{asset('assets/plugins/sidebar/sidebar.js')}}"></script>
		<script src="{{asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>
		<script src="{{asset('assets/js/sticky.js')}}"></script>
		<script src="{{asset('assets/js/modal-popup.js')}}"></script>
		<script src="{{asset('assets/plugins/side-menu/sidemenu.js')}}"></script>
		<script src="{{asset('assets/js/index.js')}}"></script>
		<script src="{{asset('assets/js/custom.js')}}"></script>
		<script src="{{asset('lib/datatables/jquery.dataTables.js')}}"></script>
		
		<script>
			$('#datatable').DataTable();
            $(".form-layout .form-control").on("focusin", function () {
            $(this).closest(".form-group").addClass("form-group-active");
            });

            $(".form-layout .form-control").on("focusout", function () {
            $(this).closest(".form-group").removeClass("form-group-active");
            });

			$('.dtpicker').datepicker({
				dateFormat: 'dd-mm-yy'
			});
        </script>
	</body>
</html>