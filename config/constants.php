<?php
return [
    'mode' => [
    1 => 'Air',
    2 => 'Road',
],
    'cargo_type' => [
    1 => 'General Cargo ',
    2 => 'Dangerous Good PAX',
    // 3 => 'DGR CAO',
    // 4 => 'Main Deck',
    // 5 => 'Pharma & Perishable',
],

    'priority' => [
    1 => 'Strandard Time',
    2 => 'Critical Time',
],

'status' => [
    1 => 'Initiate',
    2 => 'Viewed',
    3 => 'Answered',
    4 => 'Rejected',
    5 => 'Exception',
    6 => 'Confirmed',
    7 => 'Canceled',
],

'exception_status' => [
    1 => 'Active',
    2 => 'Resolved',
],

'airline_status' => [
    0 => 'Inactive',
    1 => 'Active',
],

'airline_type' => [
    1 => 'Airline',
    2 => 'Trucking',
],

'quotation_status' => [
    0 => 'Initiate',
    1 => 'Accepted',
    2 => 'Negotiate',
    3 => 'Rejected',
],

'quotation_line_item_status' => [
    0 => 'Initiate',
    1 => 'Accepted',
    2 => 'Negotiate',
    3 => 'Rejected',
],

'booking_status' => [
    0 => 'Initiate',
    1 => 'Accepted',
    2 => 'Negotiate',
    3 => 'Rejected',
],

'skids' => [
'min_skid' => 1,
'max_skid' => 4,
],

'inquiry_mode' => [
'airline_mode' => 1,
'trucking_mode' => 2,
],

    'dimension_unit' => [
    1 => 'Inch',
    2 => 'cm',
    3 => 'm',
],

    'weight_unit' => [
    1 => 'Lb',
    2 => 'Kg',
],

'special_instructions' => "
    Required for Delivery: Air Waybill (8 copies), Security Letter (1 copy)
    Custom Bonded Delivery Required",

'third_party_freight_charges' => [
    'bill_to' => "
        Ensure Freight Inc
        904 – 6550 Glen Erin Drive, Mississauga, ON L5N 3S1
        Tel: 647-989-3150
        Email: afzal@ensurefreightinc.com",
],

    'settings' => [
        'keys' => [
            'inquiry_email_notification' => [
                'key' => 'inquiry_email_notification',
                'title' => 'Please Enter Emails for Inquiries Notification '
            ]
        ]
],

    'profit' => [
        [
            'min_weight' => 0,
            'max_weight' => 1000,
            'value' => 100
        ],
        [
            'min_weight' => 1000,
            'max_weight' => 500000,
            'value' => 150
        ]
],

    'weight_ranges' => [
        1000 => 0.91,
        2000 => 0.78,
        3000 => 0.50,
        5000 => 0.65,
        12000 => 0.39,
],

    'exception_messages' => [
        'no_valid_tariff' => 'No valid tariff found for the specified date.',
        'oversized_cargo' => 'Your query for oversize cargo is under process for pricing. Standard measurement 125L x 96W x 63H',
        'under_weight_cargo' => 'Your query for Cargo is under weight. Minimum Weight for Row [ROW] is 100kg ',
        'one_skid_over_weight_cargo' => 'Your query for Cargo is over weight. Minimum Weight for Row [ROW] is 1587kg ',
        'over_weight_cargo' => 'Your query for over weight cargo is under process for pricing. Standared Weight limit per piece is 12000 KG.',
        'max_skids_exceeded' => 'Max skids quantity exceeds the allowed limit',
        'origin' => 'We are currently handling export inquiries from USA and Canada.',
        'dest' => 'We are currently unable to advise a quotation to the airport destination under Embargo and Sanction by the United Nations.',
        'cargo_invalid' => 'Invalid cargo type. Only "General Cargo" is allowed.',
        'single.skid' => 'For a single skid, the total weight should be less than 3500 lbs.',
        'no_airline_rates_found' => 'Your quotation is under process with the pricing department. Your query will be responded to soon.',
        'no_address_found' => 'Address data not found.',
        'no_carrier' => 'No active carriers found.',
        'no_mode' => 'Invalid mode selected.',
        'cargo_charge' => 'Cargo delivery charge not found.',
        'airport_not_found' => 'Airport information not found for the given City or Country.',
        'max_height' => 'Your height exceeds measurement limit for Row [ROW].' . ' Height Limit is ',
        'max_width' => 'Your width exceeds measurement limit for Row [ROW].' . ' Width Limit is ',
        'max_length' => 'Your length exceeds measurement limit for Row [ROW].' . ' Length Limit is ',
],

    'polaris' => [
        'url' => env('POLARIS_API_URL', 'https://api.polaristransport.com:1984/restgateway/services/RateAPI/Rate'),
        'key' => env('POLARIS_API_KEY', 'MzQ1NDI5OTQzMTE5MzQ4NQ'),
],

    'day' => [
        0 => 'Daily',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday',
],

    'pagination' => [
        'limit' => 10
],

    'carrier' => [
        'logo'=> [
            'path' => 'src/images/airline.jpg'
        ]

]

];
