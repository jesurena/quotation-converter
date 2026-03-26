
<div style="width: 100%;">
    <table style="width: 100%; border-collapse: collapse; font-family: 'Times New Roman', serif; font-size: 11px;">
        <thead style="display: table-header-group;">
            <tr>
                <th colspan="4" style="border: none; padding: 0; padding-bottom: 10px; font-weight: normal; text-align: left; vertical-align: top;">
                    @include('components.header')
                </th>
            </tr>
            <tr>
                <th style="padding: 4px; font-weight: bold; text-align: center; font-size: 13px; border-bottom: 1.5px solid #000; border-right: 1.5px solid #000; border-top: 1.5px solid #000; border-left: 1.5px solid #000; width: 10%;">QTY</th>
                <th style="padding: 4px; font-weight: bold; text-align: center; font-size: 13px; border-bottom: 1.5px solid #000; border-right: 1.5px solid #000; border-top: 1.5px solid #000; width: 50%;">Description</th>
                <th style="padding: 4px; font-weight: bold; text-align: center; font-size: 13px; border-bottom: 1.5px solid #000; border-right: 1.5px solid #000; border-top: 1.5px solid #000; width: 20%;">Unit Price</th>
                <th style="padding: 4px; font-weight: bold; text-align: center; font-size: 13px; border-bottom: 1.5px solid #000; border-top: 1.5px solid #000; border-right: 1.5px solid #000; width: 20%;">Total</th>
            </tr>
        </thead>
        <tbody>

        @php $count = count($quotation->lineItems); @endphp
        @foreach($quotation->lineItems as $index => $item)
            @php 
                // Normalize newlines and HTML line breaks to \n
                $descRaw = preg_replace('/<br\s*\/?>/i', "\n", $item->description);
                $descRaw = str_replace(["\r\n", "\r"], "\n", $descRaw);
                $descLines = explode("\n", $descRaw);
            @endphp

            @foreach($descLines as $lineIndex => $descLine)
                @php 
                    $trimmedLine = trim($descLine); 
                    $pt = $lineIndex === 0 ? '4px' : '0';
                    $pb = $lineIndex === (count($descLines) - 1) ? '8px' : '0';
                @endphp
                <tr>
                    <td style="padding-left: 4px; padding-right: 4px; text-align: center; vertical-align: top; font-size: 11px; border-left: 1.5px solid #000; border-right: 1.5px solid #000; padding-top: {{ $pt }}; padding-bottom: {{ $pb }};">
                        @if($lineIndex === 0)
                            {{ number_format($item->quantity) }}
                        @endif
                    </td>
                    <td style="padding-left: 4px; padding-right: 4px; vertical-align: top; font-size: 11px; border-right: 1.5px solid #000; padding-top: {{ $pt }}; padding-bottom: {{ $pb }};">
                        <div style="line-height: 1.4;">{!! $trimmedLine === '' ? '&nbsp;' : nl2br(e($descLine)) !!}</div>
                    </td>
                    <td style="padding-left: 4px; padding-right: 4px; text-align: right; vertical-align: top; font-size: 11px; border-right: 1.5px solid #000; padding-top: {{ $pt }}; padding-bottom: {{ $pb }};">
                        @if($lineIndex === 0 && $item->showItemPrices)
                            {{ number_format($item->unitPrice, 2) }}
                        @endif
                    </td>
                    <td style="padding-left: 4px; padding-right: 4px; text-align: right; vertical-align: top; font-size: 11px; border-right: 1.5px solid #000; padding-top: {{ $pt }}; padding-bottom: {{ $pb }};">
                        @if($lineIndex === 0 && $item->showItemPrices)
                            {{ number_format($item->totalPrice, 2) }}
                        @endif
                    </td>
                </tr>
            @endforeach
        @endforeach

            <tr>
                <td style="padding: 4px; border-left: 1.5px solid #000; border-right: 1.5px solid #000;"></td>
                <td style="padding: 4px; border-right: 1.5px solid #000;"></td>
                <td style="padding: 4px; text-align: right; font-weight: bold; font-size: 12px; border-right: 1.5px solid #000;">Total {{ $quotation->currency }}</td>
                <td style="padding: 4px; text-align: right; font-weight: bold; font-size: 11px; border-right: 1.5px solid #000;">
                    {{ number_format($quotation->totals->grandTotal, 2) }}
                </td>
            </tr>

            <tr>
                <td style="padding: 4px; border-right: 1.5px solid #000; border-bottom: 1.5px solid #000; border-left: 1.5px solid #000;"></td>
                <td style="vertical-align: top; font-size: 10px; border-right: 1.5px solid #000; border-bottom: 1.5px solid #000; padding: 8px;">
                    @if($quotation->showWarranty && $quotation->warranty)
                        <div style="margin-bottom: 4px;">
                            <div style="font-weight: bold;">Warranty:</div> {!! nl2br(e($quotation->warranty)) !!}
                        </div>
                    @endif

                    @if($quotation->showAvailability && $quotation->availability)
                        <div style="margin-bottom: 4px;">
                            <div style="font-weight: bold;">Availability:</div> {!! nl2br(e($quotation->availability)) !!}
                        </div>
                    @endif

                    @if($quotation->showSpecialNotes && $quotation->notes)
                        <div style="margin-bottom: 4px;">
                           <div style="font-weight: bold;">Additional Terms:</div> {!! nl2br(e($quotation->notes)) !!}
                        </div>
                    @endif

                    @if($quotation->showValidTill && $quotation->validUntil)
                        <div style="margin-bottom: 4px;">
                            <div style="font-weight: bold;">Price Valid Until:</div> {{ $quotation->validUntil }}
                        </div>
                    @endif

                    @if($quotation->showTermsOfPayment && $quotation->termsOfPayment)
                        <div style="margin-bottom: 4px;">
                            <div style="font-weight: bold;">Terms of Payment:</div> {!! nl2br(e($quotation->termsOfPayment)) !!}
                        </div>
                    @endif

                    <div style="margin-top: 8px;">
                        <div style="font-weight: bold;">Notes:</div>
                        1. Above quoted prices are subject to change in the event of changes in prevailing exchange rate, market conditions, duties, taxes and all other importation changes.<br>
                        2. Prices are subject to change without prior notice.<br>
                        3. Above quoted items are NON-CANCELABLE, once confirmed, order is placed.<br>
                        4. Above quoted prices are VAT-inclusive.
                    </div>
                </td>
                <td style="padding: 4px; border-right: 1.5px solid #000; border-bottom: 1.5px solid #000;"></td>
                <td style="padding: 4px; border-bottom: 1.5px solid #000; border-right: 1.5px solid #000;"></td>
            </tr>
        </tbody>
    </table>
</div>
