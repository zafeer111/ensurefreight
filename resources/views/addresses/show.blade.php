@extends('layouts.admin')

@section('content')

    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>Addresses</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('addresses.index') }}">Addresses</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            View Address
                        </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
                <div class="card-box height-100-p overflow-hidden">
                    <div class="profile-tab height-100-p">
                        <div class="tab height-100-p">

                            <div class="tab-content">

                                <div class="tab-pane fade show active" id="tasks" role="tabpanel">
                                    <div class="pd-20 profile-task-wrap">
                                        <div class=" pd-0">
                                            <!-- Open Task start -->
                                            <div class="task-title row align-items-center">
                                                <div class="col-md-8 col-sm-12">
                                                    <h5>{{ $addresses->country->name ?? '' }},
                                                         {{ $addresses->city->name ?? '' }} &
                                                          {{ $addresses->postal_code ?? '' }}</h5>
                                                </div>

                                            </div>
                                            <div class="profile-task-list pb-30">
                                                <ul>
                                                    <li>
                                                        <div
                                                                class="custom-control custom-checkbox mb-5"
                                                        >
                                                            <input
                                                                    type="checkbox"
                                                                    class="custom-control-input"
                                                                    id="task-1"
                                                            />
                                                            <label
                                                                    class=" "
                                                                    for="task-1"
                                                            ></label>
                                                        </div>
                                                        <div class="task-type">Full Name</div>
                                                        <span class="info-value">{{ $addresses->contact_name ?? '' }}</span>

                                                    </li>
                                                    <li>
                                                        <div
                                                                class="custom-control custom-checkbox mb-5"
                                                        >

                                                            <label
                                                                    class=" "
                                                                    for="task-2"
                                                            ></label>
                                                        </div>
                                                        <div class="task-type">Email Address</div>
                                                        <span class="info-value">{{ $addresses->contact_email ?? '' }}</span>

                                                    </li>
                                                    <li>
                                                        <div
                                                                class="custom-control custom-checkbox mb-5"
                                                        >

                                                            <label
                                                                    class=" "
                                                                    for="task-3"
                                                            ></label>
                                                        </div>
                                                        <div class="task-type">Phone#</div>
                                                        <span class="info-value">{{ $addresses->phone_number ?? '' }}</span>
                                                    </li>
                                                    <li>
                                                        <div
                                                                class="custom-control custom-checkbox mb-5"
                                                        >

                                                            <label
                                                                    class=" "
                                                                    for="task-4"
                                                            ></label>
                                                        </div>
                                                        <div class="task-type">Country</div>
                                                        <span class="info-value">{{ $addresses->country->name ?? '' }}</span>
                                                    </li>
                                                    <li>
                                                        <div
                                                                class="custom-control custom-checkbox mb-5"
                                                        >

                                                            <label
                                                                    class=" "
                                                                    for="task-4"
                                                            ></label>
                                                        </div>
                                                        <div class="task-type">State</div>
                                                        <span class="info-value">{{ $addresses->state->name ?? '' }}</span>
                                                    </li>
                                                    <li>
                                                        <div
                                                                class="custom-control custom-checkbox mb-5"
                                                        >

                                                            <label
                                                                    class=" "
                                                                    for="task-4"
                                                            ></label>
                                                        </div>
                                                        <div class="task-type">City</div>
                                                        <span class="info-value">{{ $addresses->city->name ?? '' }}</span>
                                                    </li>
                                                    <li>
                                                        <div
                                                                class="custom-control custom-checkbox mb-5"
                                                        >

                                                            <label
                                                                    class=" "
                                                                    for="task-4"
                                                            ></label>
                                                        </div>
                                                        <div class="task-type">Postal Code</div>
                                                        <span class="info-value">{{ $addresses->postal_code ?? '' }}</span>
                                                    </li>
                                                    <li>
                                                        <div
                                                                class="custom-control custom-checkbox mb-5"
                                                        >

                                                            <label
                                                                    class=" "
                                                                    for="task-4"
                                                            ></label>
                                                        </div>
                                                        <div class="task-type">Address</div>
                                                        <span class="info-value">{{ $addresses->address ?? '' }}</span>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection