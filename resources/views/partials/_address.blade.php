<div class="row">
    <div class="col-md-12">
        <h5>{{ ucfirst($type) }} Address*</h5>
    </div>

</div>

<div class="row">
    <div class="col-md-6 text-left">    
    <br>
    @if($type === 'shipper')
        <div class="form-group">
            <label for="same_as_pickup">
                <input type="checkbox" id="same_as_pickup" name="same_as_pickup">
                Same as above
            </label>
        </div>
    @endif
    </div>

    <div class="col-md-6 text-right">
        <a href="#" id="enter_{{ $type }}_address" class="enter-address-label enter-address"
           data-address-type="{{ $type }}">Enter New {{ ucfirst($type) }} Address</a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
            <div class="select-menu address-menu" data-type="{{$type}}">
                <input type="hidden" name="{{$type}}_id" value="" >
                <div class="select-btn" data-value="">
                    <span class="sBtn-text" name="previous_{{ $type }}_address"
                          id="previous_{{ $type }}_address" >Select your {{ucfirst($type)}} options
                    (<span class="addresses-counter">{{count($userAddresses)}}</span>)
                    </span>
                    <div class="caret-down-icon">&#9660;</div>
                </div>

                <ul class="options inquiry-addresses-dropdown">
                    @foreach($userAddresses as $address)
                        <li class="option" data-value="{{ $address->id }}">
                    <span class="option-text">
                        {!! $address->contact_name ? "$address->contact_name<br>" : '' !!}
                        {!! $address->contact_email ? "$address->contact_email" : '' !!}
                        {!! $address->phone_number ? "$address->phone_number<br>" : ''  !!}

                        {{ $address->address  ? $address->address  .',' : ''}}
                        {!! $address->postal_code ? "$address->postal_code <br>" :  '' !!}

                        {{ $address->state->name ? $address->state->name . ',' : ''  }}
                        {{ $address->city->name ? $address->city->name . ',' : ''  }}
                        {{ $address->country->name }}

                    </span>
                        </li>
                    @endforeach
                </ul>
            </div>

    </div>
</div>