@extends('layouts.master')

  @section('content')

    <div class="pd-30">
      <h4 class="tx-gray-800 mg-b-5">Dashboard</h4>
    </div>

    <div class="br-pagebody mg-t-5 pd-x-30">
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-primary pd-20" role="alert">
            <strong class="d-block d-sm-inline-block-force">Welcome to,</strong> Axis Cheque & MR
          </div>
        </div>
      </div>

      @if(roles() != "" && !in_array(100, json_decode(roles(),false)))
      <div class="row row-sm">
        <div class="col-sm-6 col-xl-3">
          <div class="bg-teal rounded overflow-hidden">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-university tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-13 tx-spacing-1 tx-uppercase tx-white mg-b-10 tx-semibold">Banks</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_bank}}</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
          <div class="bg-danger rounded overflow-hidden">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-id-card tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-13 tx-spacing-1 tx-uppercase tx-white mg-b-10 tx-semibold">Bank Accounts</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_account}}</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
          <div class="bg-primary rounded overflow-hidden">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-book tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-13 tx-spacing-1 tx-uppercase tx-white mg-b-10 tx-semibold">Cheque Books</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_cheque_book}}</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
          <div class="bg-br-primary rounded overflow-hidden">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-money-bill-alt tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-13 tx-spacing-1 tx-uppercase tx-white mg-b-10 tx-semibold">Cheques</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_cheque}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif

      @if(roles() != "" && in_array(100, json_decode(roles(),false)))
      <div class="row row-sm">
        <div class="col-sm-6 col-xl-3">
          <div class="bg-teal rounded overflow-hidden">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-university tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-13 tx-spacing-1 tx-uppercase tx-white mg-b-10 tx-semibold">Companies</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_company}}</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
          <div class="bg-danger rounded overflow-hidden">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-pause-circle tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-13 tx-spacing-1 tx-uppercase tx-white mg-b-10 tx-semibold">Pending</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$pending_company}}</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
          <div class="bg-primary rounded overflow-hidden">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-calendar-check tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-13 tx-spacing-1 tx-uppercase tx-white mg-b-10 tx-semibold">Active</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$active_company}}</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
          <div class="bg-br-primary rounded overflow-hidden">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-calendar-times tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-13 tx-spacing-1 tx-uppercase tx-white mg-b-10 tx-semibold">Expired</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$expired_company}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
    
  @endsection