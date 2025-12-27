                <!-- Modal for Addresses -->
                    <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="top: 100px">
                                <div class="modal-header" style="padding-left: 500px;">
                                    <h5 class="modal-title" id="addressModalLabel">Enter New Address</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <br>

                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            
                            <form id="addressForm" action="{{route('addresses.store')}}" method="POST">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_person_name">Full Name</label>
                                        <input type="text" name="contact_person_name" id="contact_person_name" placeholder="Full Name (Optional)"
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_person_email">Email Address</label>
                                        <input type="text" name="contact_person_email" id="contact_person_email" placeholder="Email Address (Optional)"
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_person_no">Phone Number</label>
                                        <input type="text" name="contact_person_no" id="contact_person_no" placeholder="Phone Number (Optional)"
                                               class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="country_id">Country<span style="color: red;">*</span></label>
                                        <select name="country_id" id="country_id" class="form-control">
                                            <option value="">Select a Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="state_id">State<span style="color: red;">*</span></label>
                                        <select name="state_id" id="state_id" class="form-control">
                                            <option value="">Select a State</option>
                                            @if (isset($states))
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="city_id">City<span style="color: red;">*</span></label>
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option value="">Select a City</option>
                                            @if (isset($cities))
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="postal_code">Postal Code <span style="color: red;">*</span></label>
                                        <input type="text" name="postal_code" id="postal_code" placeholder="Postal code"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Address <span style="color: red;">*</span></label>
                                        <textarea type="text" name="address" rows="2" cols="10" id="address" placeholder="Write address here."
                                               class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="saveAddressBtn">Save</button>
                                </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- End Modal for Addresses -->