@extends('layouts.admin')


@push('style')
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <style>
        .order-list {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-family: 'Arial', sans-serif;
        }

        .order-list th,
        .order-list td {
            text-align: center;
            padding: 8px;
            max-width: 40%;
        }

        .qty {
            text-align: left !important;
        }

        .order-list input,
        .order-list select {
            width: 50%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 3px;
            font-size: 14px;
            display: block;
        }

        .order-list .dimension-input {
            width: calc(60% - 5px);
            margin-right: 2px;
        }

        .order-list .volume-weight {
            font-style: italic;
            font-size: 14px;
            color: #555;
            padding-bottom: 35px;
        }

        .order-list .chargeable-weight {
            font-style: italic;
            font-size: 14px;
            color: #555;
            padding-bottom: 30px;
        }

        .order-list .gross-weight {
            font-style: italic;
            font-size: 14px;
            color: #555;
            padding-bottom: 30px;
        }

        .order-list .addMeasurementRow {
            background-color: #1b00ff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .order-list .addMeasurementRow:hover {
            background-color: #1400cc;
        }


        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 0.3s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }


    </style>
@endpush

@section('content')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Edit Inquiry</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('inquiries.index') }}">Inquiries</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Inquiry
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <h4 class="text-blue h4">Edit Inquiry</h4>
            </div>
            <div class="wizard-content">
                <form class="tab-wizard wizard-circle wizard" id="form" name="form"
                      action="{{ route('inquiries.update', $inquiry->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Step 1 -->
                        <h5>Origin</h5>
                        <section>
                            @include('partials._address', ['type' => 'pickup'])

                            <br>
                            <br>

                            @include('partials._address', ['type' => 'shipper'])

                            <br>
                            <br>

                        </section>

                        <!-- Step 2 -->
                        <h5>Destination</h5>
                        <section>
                        <h5>Destination*</h5>

                            <br>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mode">Mode<span style="color: red;">*</span></label>
                                    <select name="mode" id="mode" class="form-control">
                                        <option value="">Select a Mode</option>
                                        @foreach ($mode as $key => $value)
                                            <option value="{{ $key }}" @if($key == '1') selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6" id="dest_search">
                                <div class="form-group">
                                    <label for="destination_search">Destination<span style="color: red;">*</span></label>
                                    <select class="destination-search form-control" style="width: 100%;"></select>
                                </div>
                            </div>

                            <div class="col-md-6"  id="dest_postal_code" style="display: none;">
                                <div class="form-group">
                                    <label for="dest_postal_code">Destination Postal Code <span style="color: red;">*</span></label>
                                    <input type="text" name="dest_postal_code" id="dest_postal_code" placeholder="USA or Canada Postal code (Only)"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <br>
                        <br>

                        </section>


                    <!-- Step 3: Details -->
                    <h5>Details</h5>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="commodity">Item Description<span style="color: red;">*</span></label>
                                    <input type="text" name="commodity" id="commodity" class="form-control"
                                            placeholder="Item Description"
                                            value="{{ $inquiry->commodity }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="incoterms">Incoterms<span style="color: red;">*</span></label>
                                    <input type="text" name="incoterms" id="incoterms" class="form-control"
                                            placeholder="Incoterms"
                                            value="{{ old("incoterms", $inquiry->incoterms) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cargo_type">Tariff Segment<span style="color: red;">*</span></label>
                                    <select name="cargo_type" id="cargo_type" class="form-control">
                                        <option value="">Select a Tariff Segment</option>
                                        @foreach ($cargo_type as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $inquiry->cargo_type ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pickup_date">Pickup Date<span style="color: red;">*</span></label>
                                    <input type="text" name="pickup_date" placeholder="Enter Date" id="pickup_date" class="form-control" style="font-size: 14px; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
                                </div>
                            </div>
                        </div>

                        <br>

                            <h4>Special Condition for Pickup</h4>
                            <br>

                        <div class="row">

                            <div class="col-md-12">
                            <label>
                                <input type="checkbox" name="Inside_Pickup"> Is Inside Pickup?
                            </label>
                            </div>

                            <div class="col-md-12">
                            <label>
                                <input type="checkbox" name="Residential_Pickup"> Is Residential Pickup?
                            </label>
                            </div>

                            <div class="col-md-12">
                            <label>
                                <input type="checkbox" name="Liftgate_Required" id="liftgateCheckbox"> Is Lifgate required for your cargo?
                            </label>
                            </div>

                            <div class="col-md-12">
                            <label>
                                <input type="checkbox" name="Do_Not_Stack"> Is your cargo stackable?
                            </label>
                            </div>

                        </div>

                    </section>

                    <!-- Step 4: Measurements -->
                    <h5>Quantity of Skids</h5>
                    <section>
                        <table class="order-list">
                            <thead>
                            <tr>
                                <th class="qty">Quantity</th>
                                <th colspan="4">Measurements
                                    <br>
                                    (L x W x H)
                                </th>
                                <th>Volume Weight</th>
                                <th>Gross Weight</th>
                                <th>Gross Weight
                                    <br>
                                    (Converted)
                                </th>
                                <th>Chargeable Weight</th>
                                <th>Add/Remove
                                    <br>(Rows)
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($inquiry->measurements as $index => $measurement)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" name="measurements[{{ $index }}][quantity]" min="1"
                                                   style="" class="form-control dimension-input" value="{{ $measurement['quantity'] }}">
                                        </div>
                                    </td>
                                    <td colspan="4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="number" name="measurements[{{ $index }}][length]" style=""
                                                    class="form-control dimension-input"
                                                    placeholder="L"
                                                    value="{{ $measurement['length'] }}" data-row="{{ $index }}"
                                                    data-type="length">

                                                <input type="number" name="measurements[{{ $index }}][width]" style=""
                                                    class="form-control dimension-input"
                                                    placeholder="W"
                                                    value="{{ $measurement['width'] }}" data-row="{{ $index }}"
                                                    data-type="width">

                                                <input type="number" name="measurements[{{ $index }}][height]" style=""
                                                    placeholder="H"
                                                    class="form-control dimension-input"
                                                    value="{{ $measurement['height'] }}" data-row="{{ $index }}"
                                                    data-type="height">

                                                <select name="measurements[{{ $index }}][dimension_unit]" style=""
                                                    class="form-control dimension-input">
                                                    <option value="">Dimension Unit</option>
                                                    @foreach ($dimension_unit as $key => $value)
                                                        <option value="{{ $key }}" {{ $key == $measurement['dimension_unit'] ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="volume-weight"> - </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="number" name="measurements[{{ $index }}][weight]" style=""
                                                    class="form-control"
                                                    placeholder="W"
                                                    value="{{ $measurement['weight'] }}">

                                                <select name="measurements[{{ $index }}][weight_unit]" style="" class="form-control">
                                                    <option value="">Weight Unit</option>
                                                    @foreach ($weight_unit as $key => $value)
                                                        <option value="{{ $key }}" {{ $key == $measurement['weight_unit'] ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="gross-weight"> - </td>

                                    <td class="chargeable-weight"> - </td>
                                    <td>
                                    @if($loop->first)
                                        <button type="button" class="addMeasurementRow btn-sm btn-primary">Add</button>
                                    @endif
                                        <button type="button" class="deleteRow btn-sm btn-danger">Remove</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </section>

                      <!-- Step 5: Custom Broker -->
                      <h5 data-skippable="true">Custom Broker</h5>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="broker_company_name">Broker Company Name</label>
                                    <input type="text" name="broker_company_name" id="broker_company_name"
                                           class="form-control" value="{{ old('company_name', $inquiry->brokerDetail->company_name ?? '') }}"
                                           placeholder="Company Name (Optional)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_name">Contact Name</label>
                                    <input type="text" name="contact_name" id="contact_name"
                                           class="form-control" value="{{ old('contact_name', $inquiry->brokerDetail->contact_name ?? '') }}"
                                           placeholder="Contact Name (Optional)">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone No</label>
                                    <input type="text" name="phone" id="phone"
                                           class="form-control" value="{{ old('phone', $inquiry->brokerDetail->phone ?? '') }}"
                                           placeholder="Phone Number (Optional)">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="text" name="email" id="email"
                                           class="form-control" value="{{ old('email', $inquiry->brokerDetail->email ?? '') }}"
                                           placeholder="Email Address (Optional)">
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Step 6: Other Details -->
                    <h5>Other Details</h5>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="priority">Priority<span style="color: red;">*</span></label>
                                    <select name="priority" id="priority" class="form-control">
                                        <option value="">Select a Priority</option>
                                        @foreach ($priority as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $inquiry->priority ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pickup_reference">Pickup Reference<span style="color: red;">*</span></label>
                                    <input type="text" name="pickup_reference"
                                    id="pickup_reference" class="form-control"
                                    placeholder="Pickup Reference"
                                    value="{{ $inquiry->pickup_reference }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notes">Notes<span style="color: red;">*</span></label>
                                    <textarea name="notes" id="notes" placeholder="Write additional note here."
                                    class="form-control" rows="4">{{ $inquiry->notes }}</textarea>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>

            <!-- success Popup html Start -->
            <div
            class="modal fade"
            id="success-modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center font-18">
                                <h3 class="mb-120">Form Submitted!</h3>
                                <div class="mb-80 text-center">
                                    <img src="vendors/images/success.png"/>
                                </div>
                                <script>
                                    var baseUrl = "{{ asset('vendors') }}";
                                </script>
                            </div>

                            <!-- <div class="modal-footer justify-content-center">
                            </div> -->

                        </div>
                    </div>
            </div>
            <!-- success Popup html End -->

            @include('partials._address-modal')

    </div>
@endsection


@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="{{ asset('src/plugins/jquery-steps/jquery.steps.js') }}"></script>
    <script src="{{ asset('vendors/scripts/measurement.js') }}"></script>
    <script src="{{ asset('vendors/scripts/inquiry-validations.js') }}"></script>
    <script src="{{ asset('vendors/scripts/select-menu.js') }}"></script>
    <script src="{{ asset('vendors/scripts/address-modal.js') }}"></script>
    <script src="{{ asset('vendors/scripts/get-states.js') }}"></script>


    <script>
        let selectedDestination = '';
        let selectedDestinationiata = '';
        let countryIso2;

        $('.destination-search').select2({
            placeholder: "Search Airport by IATA Code OR City Name",
            ajax: {
                url: '{{route('api.airports')}}',
                data: function (params) {
                    var query = {
                        query: params.term,
                    }
                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                dataType: 'json',
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj) {
                            return {
                                id: obj.id,
                                text: obj.iata_code + ' - ' + (obj.city ? obj.city.name : '') + ', ' + (obj.country ? obj.country.iso2 : ''),
                            };
                        })
                    };
                }
            },

        });

        $('.destination-search').on('select2:select', function (e) {
        const selectedOption = e.params.data;
        if (selectedOption && selectedOption.id) {
            selectedDestination = selectedOption.id;
            selectedDestinationiata = selectedOption.text.split(' ')[0];
            
            countryCode = selectedOption.text.split(',').map(part => part.trim());
            countryIso2 = countryCode[countryCode.length - 1];
        }
        });


        // On mode selection change
        $("#mode").change(function () {
            const mode = $(this).val();

            if (mode === '1') {
                $(".destination-search").next(".select2-container").show();
                $("#dest_postal_code").hide();
                $("#dest_search").show();
            } else if (mode === '2') {
                $(".destination-search").next(".select2-container").hide();
                $("#dest_postal_code").show();
                $("#dest_search").hide();
            }
        });

    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Datepicker
            $("#pickup_date").datepicker({
                // Set the Date format
                dateFormat: 'yy-mm-dd',
                // Disable Weekends
                beforeShowDay: $.datepicker.noWeekends,
                // Disable past dates
                minDate: 0 // 0 means today's date, 1 means tomorrow, -1 means yesterday
            });
        });
    </script>

@endpush
