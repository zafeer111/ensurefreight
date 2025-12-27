@extends('layouts.admin')


@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Addresses</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                            <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            List Address
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Simple Datatable start -->
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Addresses</h4>
        </div>
        <div class="pb-20">
            <table class="data-table table stripe hover nowrap">
                <thead>
                <tr>
                    <th class="table-plus datatable-nosort">Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th class="datatable-nosort">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($addresses as $address)
                    <tr>
                        <td class="table-plus">{{ $address->contact_name }}</td>
                        <td>{{ $address->contact_email }}</td>
                        <td>{{ $address->phone_number }}</td>
                        <td>{{ $address->country->name }}</td>
                        <td>{{ $address->state->name }}</td>
                        <td>{{ $address->city->name }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        type="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <a class="dropdown-item" href="{{ route('addresses.show', $address->id) }}"><i
                                                class="dw dw-eye"></i> View</a>
                                    <a class="dropdown-item" href="{{ route('addresses.edit', $address->id) }}"><i
                                                class="dw dw-edit2"></i> Edit</a>
                                    <a href="#" class="dropdown-item delete-address"
                                       data-address-id="{{ $address->id }}">
                                        <i class="dw dw-delete-3"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Simple Datatable End -->

@endsection


@push('script')

    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('.delete-address').on('click', function (e) {
                e.preventDefault();

                // Extract the address ID from the data attribute
                var addressId = $(this).data('address-id');

                // Show confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this address!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    confirmButtonColor: '#FF0000',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User clicked "Yes, delete it!"
                        deleteAddress(addressId);
                    }
                });
            });

            function deleteAddress(addressId) {
                $.ajax({
                    type: 'DELETE',
                    url: '/addresses/' + addressId,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The address has been deleted successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });

                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    },
                    error: function (error) {
                        console.log(error.responseJSON);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to delete the address. Please try again.',
                            icon: 'error',
                        });
                    }
                });
            }
        });

    </script>
@endpush