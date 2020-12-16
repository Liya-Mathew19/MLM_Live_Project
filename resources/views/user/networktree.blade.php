@extends('layouts.user')
@section('content')
<head>
<link rel="stylesheet" href="{{env('APP_URL')}}/vendors/tree/css/hierarchy-view.css">
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/tree/css/main.css">
</head>
<!--Management Hierarchy-->
@php
$user=$results['user'];
$account=$results['acct_id'];
$child=$results['child'];
@endphp


    <div class="row mt-4">
		<div class="col-lg-12 grid-margin ">
			<div class="card card-danger card-outline card-outline-danger">
				<div class="card-header">
						<h4 class="card-title">Network Tree View</h4>
				</div>
				<div class="card-body">
    <section class="management-hierarchy">
        <div class="hv-container">
            <div class="hv-wrapper">
                <!-- Key component -->
                <div class="hv-item">
                    <div class="hv-item-parent">
                        <div class="person">
                            <img src="{{env('APP_URL')}}/vendors/admin/images/usericon.png" alt="">
                            <p class="name">{{\App\Helper\PaymentHelper::bind_account_number($account)}}</p>
                        </div>
                    </div>

                    <div class="hv-item-children">
                    @foreach($child as $childs)
                        <div class="hv-item-child">
                            <!-- Key component -->
                            <div class="hv-item">
                                <div class="hv-item-parent">
                                    <div class="person">
                                        <img src="{{env('APP_URL')}}/vendors/admin/images/usericon.png" alt="">
                                        <p class="name"> {{$childs}}</b> </p>
                                    </div>
                                </div>

                                <div class="hv-item-children">
                                    <div class="hv-item-child">
                                        <div class="person">
                                            <img src="{{env('APP_URL')}}/vendors/admin/images/usericon.png" alt="">
                                            <p class="name">{{json_encode(\App\Helper\Helper::get_children($childs))}}</b></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection