<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill of Lading</title>

    <style>
        /* http://meyerweb.com/eric/tools/css/reset/
   v2.0 | 20110126
   License: none (public domain)
*/

        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section {
            display: block;
        }
        body {
            line-height: 1;
        }
        ol, ul {
            list-style: none;
        }
        blockquote, q {
            quotes: none;
        }
        blockquote:before, blockquote:after,
        q:before, q:after {
            content: '';
            content: none;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
    </style>
<style>
    /*__________________________________________________Universal
Universal
*/

    body {
        background-color: #F0F0F0;
        font-size: 100%;
        color: #000;
        font-family: Arial, Helvetica, sans-serif;
    }

    .left {
        float: left;
    }

    .right {
        float: right;
    }

    .clear {
        clear: both;
    }

    input, textarea {
        margin: 0;
        padding: 0;
        border: none;
        outline: none;
        background: transparent;
        font-family: Arial, Helvetica, sans-serif;
    }

    p	{
        font-size: 1em;
        padding: 2px 0;
    }

    h2 {
        margin-bottom: 5px;
        color: #333;
        font-size: 1.1em;
        font-weight: bold;
    }

    strong {
        font-weight: bold;
    }

    textarea {
        display: block;
        background: #E3FAFA;
        resize: none;
    }

    input {
        background: #E3FAFA;
    }

    input:hover, textarea:hover {
        background: #FFFFCC;
    }

    input:focus, textarea:focus {
        border: 1px solid #666;
    }

    .price:hover {
        background: #FFF;
    }

    .price:focus {
        border: none;
    }

    .button {
        display: inline;
        padding: 4px 8px;
        background-color: #008cba;
        color: #FFF;
        font: .95em Helvetica;
        text-decoration: none;
    }

    .button:hover {
        color: #FFF;
        background-color: #006f94;
    }

    .green {
        background-color: #4CAF50;
        color: #FFF;
        font: .95em Helvetica;
    }

    .green:hover {
        background-color: #46a049;
    }

    /*__________________________________________________Head
    Head
    */

    #head, #how-to {
        margin: 0 auto;
        padding-top: 10px;
        margin-bottom: 20px;
        width: 864px;
    }

    h1 {
        padding-bottom: 10px;
        color: #333;
        font-weight: normal;
        font-size: 1.5em;
        display:inline;
    }

    h1 a {
        text-decoration: none;
        color: #333;
    }

    a.nav-link {
        text-decoration: none;
        color: #333;
    }

    #about {
        margin-top: 30px;
    }

    #about-head {
        margin-bottom: 10px;
    }

    h3 {
        color: #333;
        font-size: 1.4em;
        display: inline;
    }

    #about {
        padding: 5px;
        background: #EEE;
        color: #333;
        border: 1px solid #666;
    }

    #how-to {
        padding: 5px;
        background: #FFF;
        color: #333;
        border: 1px solid #666;
    }

    #about p, #how-to p {
        padding-bottom: 10px;
    }

    /*__________________________________________________Banner Ad
    Banner AD
    */

    #banner-ad {
        margin: 20px 0px;
    }

    /*__________________________________________________Actions
    Actions
    */

    #actions {
        margin: 0 auto;
        padding-top: 10px;
        margin-bottom: -20px;
        width: 864px;
    }

    /*__________________________________________________Main
    Main
    */

    #main {
        margin: 30px auto;
        padding: 32px;
        width: 800px;
        height: 1040px;
        background: #FFF;
        border: 1px solid #808080;
    }

    /*__________________________________________________Invoice
    Invoice
    */

    form p, form span {
        font-size: .85em;
        padding: 0;
    }

    /*change*/
    form input {
        height: 12px;
    }

    /*change*/
    form input, form textarea {
        line-height: 12px;
    }

    #invHeader {
    }

    #headLeft {
        float: left;
        width: 400px;
        border-bottom: 1px solid #CCC;
    }

    #headLeft h1 {
        font-size: 2em;
        font-weight: bold;
        padding-bottom: 16px;
        color: #000;
    }

    #headRight h1 {
        font-size: 2em;
        font-weight: bold;
        padding-bottom: 16px;
        color: #000;
    }

    #headLeft p, #headRight p, #headRight span, #inst {
        font-weight: bold;
        font-size: .85em;
    }

    #headLeft div {
        padding: 4px;
        border-top: 1px solid #CCC;
        border-left: 1px solid #CCC;
    }

    #headLeft textarea {
        font-size: .85em;
        text-align: left;
        width: 100%;
        height: 50px;
    }

    #headRight {
        margin-top: 21px;
        float: left;
        width: 400px;
        border-top: 1px solid #CCC;
    }

    #headRight .border {
        border-bottom: 1px solid #CCC;
        border-left: 1px solid #CCC;
        border-right: 1px solid #CCC;
        padding: 4px;
    }

    #headRight .inlineSpan span {
        display: table-cell;
        white-space: nowrap;
    }

    #headRight .barcode {
        padding: 10px 0px;
        color: #CCC;
        font-size: 1.5em;
        font-weight: bold;
    }

    #headRight .barcode span {
        display:block;
        width: 100%;
        text-align: center;
    }

    #headRight .fullWidth, #headRight .fullWidth input{
        width: 100%;
    }

    #headRight input[type=textarea] {
        margin-bottom: 8px;
        width: 100%;
        display: block;
    }

    #headRight input[type=text] {
        margin-bottom: 4px;
    }

    #inst {
        padding: 4px;
        border-left: 1px solid #CCC;
        border-right: 1px solid #CCC;
    }

    #inst textarea {
        text-align: left;
        width: 100%;
        height: 25px;
    }

    table {
        width: 800px;
        font-size: .9em;
    }

    table {
        border-collapse: collapse;
        border-left: 1px solid #CCC;
        border-right: 1px solid #CCC;
    }

    table td, table th {
        padding: 1px;
        border: 1px solid #CCC;
    }

    table th {
        text-align: center;
        font-weight: bold;
        font-size: .75em;
    }

    table .tableBanner {
        color: white;
        background: black;
    }

    table tr td input {
        width: 100%;
    }

    table tr td textarea {
        margin-top: -16px;
        width: 100%;
        height: 24px;
        font-size: 1em;
    }

    .totals {
        font-weight: bold;
    }

    .blocked {
        background: #CCC;
    }

    #ftrBox	{
        border-right: 1px solid #CCC;
        border-top: 2px solid black;
    }

    #ftrBox input[type=checkbox] {
        margin: 4px;
    }

    #ftrBox input[type=text] {
        border-bottom: 1px solid black;
    }

    .ftr {
        font-size: .7em;
        padding: 4px;
        border-bottom: 1px solid #CCC;
        border-left: 1px solid #CCC;
    }

    .two-col {
        width: 390px;
    }

    #shipper {
        font-size: 12px !important;
        white-space: nowrap;
        padding: 5px;
        font-weight: normal !important;
    }

    #shipTo {
        font-size: 12px !important;
        white-space: nowrap;
        padding-top: 5px;
        min-height: 70px;
        resize: vertical;
        font-weight: normal !important;
    }

    #notes {
        font-size: 12px !important;
        white-space: nowrap;
        padding: 5px;
        resize: vertical;
        font-weight: normal !important;
    }

    #thirdPty {
        font-size: 12px !important;
        white-space: nowrap;
        padding: 5px;
        font-weight: normal !important;
    }

</style>
</head>
<body>
<div id="main">
    <form id="form" action="topdf.php" method="post">
        <div id="invHeader">
            <div id="headLeft">
                <h1>Bill of Lading</h1>
                <div style="margin-top: 16px;">
                    <p>Ship From:</p><p>
                        <textarea id="shipper">
                        {{ preg_replace('/\r|\n/', '', $inquiry->pickupAddress->contact_name) }}, {{ $inquiry->pickupAddress->contact_email }}
                        {{ preg_replace('/\r|\n/', '', $inquiry->pickupAddress->address) }}
                        {{ $inquiry->pickupAddress->postal_code }}, {{ $inquiry->pickupAddress->state->name }}, {{ $inquiry->pickupAddress->city->name }}, {{ $inquiry->pickupAddress->country->name }}
                        </textarea>
                    </p><div style="border:none;float:left;width:300px">
                        <span>SID#: </span><input type="text" id="sid">
                    </div>
                    <div style="border:none;float:left;">
                        <input type="checkbox" id="fobOne"><span> FOB</span>
                    </div>
                    <div style="border:none;padding:0;margin:0" class="clear"><!--empty--></div>
                </div>
                <div>
                    <div style="border:none;float:left;width:185px">
                        <p>Ship To:</p>
                        <p>
                        </p>
                    </div>
                    <div style="border:none;float:left">
                        <span>Location No:</span><input type="text" size="6" id="locNo">
                    </div>
                    <div style="border:none" class="clear"><!--empty--></div>
                    <textarea id="shipTo">
                    {{ $airline_address->sub_address }} (Port {{ $airline_address->port }}, Sub-location {{ $airline_address->sub_location }})
                    {{ $airline_address->address }},
                    {{ $airline_address->city }}, {{ $airline_address->state }}, {{ $airline_address->postal_code }}
                    Tel: {{ $airline_address->tel }}
                    Contact: {{ $airline_address->contact }}
                    </textarea>
                    <div style="border:none;float:left;width:300px">
                        <span>CID#: </span><input type="text" id="cid">
                    </div>
                    <div style="border:none;float:left;">
                        <input type="checkbox" id="fobTwo"><span> FOB</span>
                    </div>
                    <div style="border:none;padding:0;margin:0" class="clear"><!--empty--></div>
                </div>
                    <div>
                        <p>Third Party Freight Charges - Bill To:</p><p>
                            <textarea id="thirdPty">{{ constants('third_party_freight_charges.bill_to') }}</textarea>
                        </p>
                    </div>
            </div><!--end headLeft-->
            <div id="headRight">
                <div class="inlineSpan border">
                    <span>Date: {{ date('d-F-Y', strtotime($booking->created_at)) }} </span>
                </div>
                <div class="inlineSpan border">
                    <span>Bill of Lading No: {{ $booking->referenceNo->reference_no }}</span>
                    <div class="barcode">
							<span>BARCODE SPACE<span>
						</span></span></div>
                </div>
                <div class="inlineSpan border">
                    <div>
                        <span>Carrier Name: {{$quotation->pickup_carrier_name}}</span>
                    </div>
                    <div>
                        <span>Trailer No:</span>
                        <span class="fullWidth">&nbsp;<input type="text" id="trailer"></span>
                    </div>
                    <div>
                        <span>Seal Number(s):</span>
                        <span class="fullWidth">&nbsp;<input type="text" id="seal"></span>
                    </div>
                </div>
                <div class="inlineSpan border">
                    <div>
                        <span>SCAC:</span>
                        <span class="fullWidth">&nbsp;<input type="text" id="SCAC"></span>
                    </div>
                    <div>
                        <span>Pro No:</span>
                        <span class="fullWidth">&nbsp;<input type="text" id="ProNo"></span>
                    </div>
                    <div class="barcode">
							<span>BARCODE SPACE<span>
						</span></span></div>
                </div>
                <div class="border">
                    <p style="padding-bottom:6px;">Freight Charge Terms (prepaid unless marked otherwise)</p>
                    <input type="checkbox" id="pre"><span> Prepaid</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="col"><span> Collect</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="third"><span> 3rd Party</span>
                </div>
                <div class="border">
                    <input type="checkbox" id="masterBOL"><span> Master BOL: w/attached underlying BOLs</span>
                </div>
            </div><!--end headRight"-->
            <div class="clear"><!--empty--></div>
            <div id="inst">
                <p>Special Instructions:</p>
                <textarea id="notes">{{ constants('special_instructions') }}</textarea>
            </div>
        </div><!--end invHeader-->
        <div id="invTable">
            <table id="items">
                <thead>
                <tr>
                    <th class="tableBanner" colspan="5">Customer Order Information</th>
                </tr>
                <tr>
                    <th>Customer Order No.</th>
                    <th># Pkgs.</th>
                    <th>Weight</th>
                    <th>Pallet/Slip  (Y/N) </th>
                    <th>Additional Shipper Info</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width:135px;"><input type="text" id="ordNo_1"> SC# {{$bol['customer_order_no']}} </td>
                    <td style="width:45px;"><input type="text" class="pkgs" id="pkgs_1"> {{$bol['packages']}} </td>
                    <td style="width:60px;"><input type="text" class="wght" id="wght_1"></td>
                    <td style="width:55px;"><input type="text" id="pallet_1"></td>
                    <td><input type="text" id="shipInfo_1"> SC# {{$bol['customer_order_no']}} </td>
                </tr>
                <tr>
                    <td><input type="text" id="ordNo_2"></td>
                    <td><input type="text" class="pkgs" id="pkgs_2"></td>
                    <td><input type="text" class="wght" id="wght_2"></td>
                    <td><input type="text" id="pallet_2"></td>
                    <td><input type="text" id="shipInfo_2"></td>
                </tr>

                    @php
                    $totalWeight = 0;
                    $totalSkids = 0;
                    @endphp

                    @foreach ($inquiry->measurements as $index => $measurement)
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $measurement->weight }}
                                @foreach (config('constants.weight_unit') as $key => $value)
                                    @if ($key == $measurement->weight_unit)
                                    {{ $value }}
                                    @endif
                                @endforeach
                            </td>
                            <td></td>
                            <td>
                                {{ $measurement->height }} x {{ $measurement->width }} x {{ $measurement->length }} 
                                @foreach (config('constants.dimension_unit') as $key => $value)
                                    @if ($key == $measurement->dimension_unit)
                                        {{ $value }}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        @php
                        $totalWeight += $measurement->weight;
                        $totalSkids += $measurement->quantity;
                        @endphp
                    @endforeach
                
                <tr>
                    <td><input type="text" id="ordNo_3"></td>
                    <td><input type="text" class="pkgs" id="pkgs_3"></td>
                    <td><input type="text" class="wght" id="wght_3"></td>
                    <td><input type="text" id="pallet_3"></td>
                    <td><input type="text" id="shipInfo_3"></td>
                </tr>
                
                </tbody>
                <tfoot>
                <tr class="totals">
                    <td>Totals</td>
                    <td><div id="total-pkgs"> {{$bol['packages']}} </div></td>
                    <td><div id="total-wght"></div>{{$totalWeight}} 
                    <span>
                        @foreach (config('constants.weight_unit') as $key => $value)
                            @if ($key == $measurement->weight_unit)
                                {{$value}}
                            @endif
                        @endforeach
                    </span>
                    </td>
                    <td><div id="total-pallet"></div></td>
                    <td><div id="shipInfo_3"> {{$totalSkids}} Skids</div></td>

                </tr>
                </tfoot>
            </table>


            <table id="carrier">
                <thead>
                <tr>
                    <th class="tableBanner" colspan="9">Carrier Information</th>
                </tr>
                <tr>
                    <th colspan="2">Handling Unit</th>
                    <th colspan="2">Package</th>
                    <td class="blank" colspan="2"> </td>
                    <th>Commodity Description</th>
                    <th colspan="2">LTL Only</th>
                </tr>
                <tr>
                    <th>QTY</th>
                    <th>TYPE</th>
                    <th>QTY</th>
                    <th>TYPE</th>
                    <th>Weight</th>
                    <th>H.M. (X)</th>
                    <th style="font-size:.65em;font-weight:normal;">Commodities requiring special or additional care or attention in handling or stowing must be so marked and packaged as to ensure safe transportation with ordinary care. <p><strong>See Section 2(e) of MNMFC Item 360</strong></p></th>
                    <th>NMFC No.</th>
                    <th>Class</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td style="width:45px;"><input type="text" class="qtyA" id="qtyA_1">{{$bol['quantity_number']}}</td>
                    <td style="width:45px;"><input type="text" id="typeA_1">{{$bol['select_type']}}</td>
                    <td style="width:45px;"><input type="text" class="qtyB" id="qtyB_1"> {{$totalSkids}} </td>
                    <td style="width:45px;"><input type="text" id="typeB_1">Skids</td>
                    <td style="width:45px;"><input type="text" class="carWght" id="carWght_1"> {{$totalWeight}} </td>
                    <td style="width:45px;"><input type="text" id="hm_1"></td>
                    <td><input type="text" id="desc_1"> {{$inquiry->commodity}} </td>
                    <td style="width:45px;"><input type="text" id="nmfc_1">{{$bol['nmfc_no']}}</td>
                    <td style="width:45px;"><input type="text" id="class_1">{{$bol['class']}}</td>
                </tr>
                <tr>
                    <td><input type="text" class="qtyA" id="qtyA_2"></td>
                    <td><input type="text" id="typeA_2"></td>
                    <td><input type="text" class="qtyB" id="qtyB_2"></td>
                    <td><input type="text" id="typeB_2"></td>
                    <td><input type="text" class="carWght" id="carWght_2"></td>
                    <td><input type="text" id="hm_2"></td>
                    <td><input type="text" id="desc_2"></td>
                    <td><input type="text" id="nmfc_2"></td>
                    <td><input type="text" id="class_2"></td>
                </tr>
                </tbody>

                <tfoot>
                <tr class="totals">
                    <td><div id="handling-qty"> {{ $bol['quantity_number']}}</div></td>
                    <td class="blocked"> </td>
                    <td><div id="package-qty"> {{ $totalSkids}}</div></td>
                    <td class="blocked"> </td>
                    <td><div id="carrier-weight"> {{ $totalWeight}}</div></td>
                    <td class="blocked"> </td>
                    <td>Totals</td>
                    <td class="blocked"> </td>
                    <td class="blocked"> </td>

                </tr>
                </tfoot>
            </table>
        </div><!--end invTable-->
        <div id="ftrBox">
            <div class="ftr left two-col" style="height:65px">
                <p style="margin-bottom: 6px;">Where the rate is dependent on value, shippers are required to state specifically in writing the agreed or declared value of the property as follows:</p>
                <p style="margin-bottom: 6px;">"The agreed or declared value of the property is specifically stated by the shipper to be not exceeding."</p>
                <u>{{ strtoupper($bol['currency']) }}  -  {{$bol['amount']}}/-</u><span>   FOB   </span><u>{{ucfirst($bol['fob'])}}</u>
            </div>
            <div class="ftr left two-col" style="height:65px;font-size:1em;">
                <p style="padding:6px 0;"><strong>COD Amt. $</strong><input type="text" id="COD"></p>
                <p><strong>Fee Terms:</strong><span><input type="checkbox" id="collect">Collect</span><input type="checkbox" id="prepaid"><span>Prepaid</span></p>
                <p><input type="checkbox" id="checkOK"><span>Customer Check Acceptable</span></p>
            </div>
            <div class="clear"><!--empty--></div>
            <div class="ftr" style="height:10px">
                <p><strong>NOTE: Liability Limitation for loss or damage in this shipment may be applicable. See 49 U.S.C. - 14706(c)(1)(A) and (B).</strong></p>
            </div>
            <div class="ftr left two-col" style="height:45px">
                <p>RECEIVED, subject to individually determined rates or contracts that have been agreed upon in writing between the carrier and shipper, if applicable, otherwise to the rates, classifications and rules that have been established by the carrier and are available to the shipper, on request, and to all applicable state and federal regulations.</p>
            </div>
            <div class="ftr left two-col" style="height:45px">
                <p>The carrier shall not make delivery of this shipment without payment of freight and all other lawful charges.</p>
                <div class="left" style="margin-top:16px;">Shipper Signature</div><div class="left" style="width:200px;height:24px;border-bottom:1px solid black"></div>
                <div class="clear"><!--empty--></div>
            </div>
            <div class="clear"><!--empty--></div>
            <div class="ftr left" style="height:85px;width:237px;font-size:.65em">
                <p>This is to certify that the above named materials are properly classified, packaged, marked and labeled, and are in proper condition for transportation according to the applicable regulations of the DOT.</p>

                <div class="left" style="width:150px;margin-right:10px">
                    <div style="width:150px;height:36px;border-bottom:1px solid black"></div>
                    <p>Shipper Signature</p>
                </div>
                <div class="left">
                    <div style="width:75px;height:36px;border-bottom:1px solid black"></div>
                    <p>Date</p>
                </div>

            </div>
            <div class="ftr left" style="height:85px;width:257px">
            <div class="left" style="width:85px;">
                <p><strong>Trailer Loaded</strong></p>
                <p><input type="checkbox" id="loadedByShip" {{ $bol['trailer_loaded_shipper'] ? 'checked' : '' }}>By Shipper</p>
                <p><input type="checkbox" id="loadedByDrive" {{ $bol['trailer_loaded_driver'] ? 'checked' : '' }}>By Driver</p>
            </div>
            <div class="left">
                <p><strong>Freight Counted</strong></p>
                <p><input type="checkbox" id="countedByShip" {{ $bol['freight_counted_shipper'] ? 'checked' : '' }}>By Shipper</p>
                <p><input type="checkbox" id="countedByDriveOne" {{ $bol['freight_counted_driver_pallets'] ? 'checked' : '' }}>By Driver/pallets said to contain</p>
                <p><input type="checkbox" id="countedByDriveTwo" {{ $bol['freight_counted_driver_pieces'] ? 'checked' : '' }}>By Driver/Pieces</p>
            </div>
                <div class="clear"><!--empty--></div>
            </div>
            <div class="ftr left" style="height:85px;width:276px;font-size:.65em;">
                <p>Carrier acknowledges receipt of packages and required placards. Carrier certifies emergency response information was made available and/or carrier has the DOT emergency response guidebook or equivalent documentation in the vehicle. Property described above is received in good order, except as noted.</p>
                <div class="left" style="width:150px;margin-right:10px">
                    <div style="width:150px;height:30px;border-bottom:1px solid black"></div>
                    <p>Carrier Signature</p>
                </div>
                <div class="left">
                    <div style="width:75px;height:30px;border-bottom:1px solid black"></div>
                    <p>Pickup Date</p>
                </div>
            </div>
            <div class="clear"><!--empty--></div>
        </div>
    </form>
</div>
</body>
</html>
