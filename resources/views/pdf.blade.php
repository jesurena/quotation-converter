<style>
    @font-face {
        font-family: 'Times New Roman';
        font-weight: normal;
        font-style: normal;
    }

    * {
        font-family: 'Times New Roman', serif;
        font-size: 11px;
    }

    .p-1 { padding: 4px; }
    .p-2 { padding: 8px; }
    .p-3 { padding: 12px; }
    .p-4 { padding: 16px; }
    
    .px-1 { padding-left: 4px; padding-right: 4px; }
    .px-2 { padding-left: 8px; padding-right: 8px; }
    .px-3 { padding-left: 12px; padding-right: 12px; }
    .px-4 { padding-left: 16px; padding-right: 16px; }
    
    .py-1 { padding-top: 4px; padding-bottom: 4px; }
    .py-2 { padding-top: 8px; padding-bottom: 8px; }
    .py-3 { padding-top: 12px; padding-bottom: 12px; }
    .py-4 { padding-top: 16px; padding-bottom: 16px; }

    .pt-1 { padding-top: 4px; }
    .pt-2 { padding-top: 8px; }
    .pt-3 { padding-top: 12px; }
    .pt-15 { padding-top: 15px; }

    .pb-1 { padding-bottom: 4px; }
    .pb-2 { padding-bottom: 8px; }
    .pb-3 { padding-bottom: 12px; }
    .pb-4 { padding-bottom: 16px; }

    .mt-1 { margin-top: 4px; }
    .mt-2 { margin-top: 8px; }
    .mt-8 { margin-top: 32px; }

    .mb-1 { margin-bottom: 4px; }
    .mb-2 { margin-bottom: 8px; }
    .mb-3 { margin-bottom: 12px; }
    .mb-8 { margin-bottom: 32px; }

    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .text-justify { text-align: justify; }
    .font-bold { font-weight: bold; }
    .uppercase { text-transform: uppercase; }
    .w-full { width: 100%; }
    .align-top { vertical-align: top; }
    .border-collapse { border-collapse: collapse; }
    
    .text-4xs { font-size: 6px; }
    .text-3xs { font-size: 7px; }
    .text-2xs { font-size: 8px; }
    .text-tiny { font-size: 9px; }
    .text-xs { font-size: 10px; }
    .text-sm { font-size: 11px; }
    .text-base { font-size: 12px; }
    .text-lg { font-size: 13px; }
    .text-xl { font-size: 15px; }
    .text-2xl { font-size: 17px; }
    .text-3xl { font-size: 20px; }
    .text-4xl { font-size: 26px; }
    
    .max-w-60 { max-width: 60%; }
    .max-w-70 { max-width: 70%; }
    .max-w-80 { max-width: 80%; }
    .max-w-85 { max-width: 85%; }
    .max-w-100 { max-width: 100%; }

    .item-description {
        line-height: 1.4;
    }
</style>

<div class="quotation-content">
    <table class="w-full" style="border: 1.5px solid #000; border-collapse: collapse; table-layout: fixed;">
        <thead>
            <tr>
                <th class="p-1 font-bold text-center text-lg" style="border-bottom: 1.5px solid #000; border-right: 1.5px solid #000; width: 10%;">QTY</th>
                <th class="p-1 font-bold text-center text-lg" style="border-bottom: 1.5px solid #000; border-right: 1.5px solid #000; width: 50%;">Description</th>
                <th class="p-1 font-bold text-center text-lg" style="border-bottom: 1.5px solid #000; border-right: 1.5px solid #000; width: 20%;">Unit Price</th>
                <th class="p-1 font-bold text-center text-lg" style="border-bottom: 1.5px solid #000; width: 20%;">Total</th>
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
                    <td class="px-1 text-center align-top text-sm" style="border-right: 1.5px solid #000; padding-top: {{ $pt }}; padding-bottom: {{ $pb }};">
                        @if($lineIndex === 0)
                            {{ number_format($item->quantity) }}
                        @endif
                    </td>
                    <td class="px-1 align-top text-sm" style="border-right: 1.5px solid #000; padding-top: {{ $pt }}; padding-bottom: {{ $pb }};">
                        <div class="item-description">{!! $trimmedLine === '' ? '&nbsp;' : nl2br(e($descLine)) !!}</div>
                    </td>
                    <td class="px-1 text-right align-top text-sm" style="border-right: 1.5px solid #000; padding-top: {{ $pt }}; padding-bottom: {{ $pb }};">
                        @if($lineIndex === 0 && $item->showItemPrices)
                            {{ number_format($item->unitPrice, 2) }}
                        @endif
                    </td>
                    <td class="px-1 text-right align-top text-sm" style="padding-top: {{ $pt }}; padding-bottom: {{ $pb }};">
                        @if($lineIndex === 0 && $item->showItemPrices)
                            {{ number_format($item->totalPrice, 2) }}
                        @endif
                    </td>
                </tr>
            @endforeach
        @endforeach

            <tr>
                <td class="p-1" style="border-top: 1.5px solid #000;"></td>
                <td class="p-1 text-right font-bold text-base" style="border-top: 1.5px solid #000; border-right: 1.5px solid #000;">TOTAL AMOUNT:</td>
                <td class="p-1" style="border-top: 1.5px solid #000;"></td>
                <td class="p-1 text-right font-bold text-sm" style="border-top: 1.5px solid #000;">
                    {{ $quotation->currency }} {{ number_format($quotation->totals->grandTotal, 2) }}
                </td>
            </tr>

            <tr>
                <td class="p-1" style="border-top: 1.5px solid #000; border-right: 1.5px solid #000;"></td>
                <td class="p-2 align-top text-xs" style="border-top: 1.5px solid #000; border-right: 1.5px solid #000; padding: 8px;">
                    @if($quotation->showWarranty && $quotation->warranty)
                        <div class="mb-1">
                            <div class="font-bold">Warranty:</div> {!! nl2br(e($quotation->warranty)) !!}
                        </div>
                    @endif

                    @if($quotation->showAvailability && $quotation->availability)
                        <div class="mb-1">
                            <div class="font-bold">Availability:</div> {!! nl2br(e($quotation->availability)) !!}
                        </div>
                    @endif

                    @if($quotation->showSpecialNotes && $quotation->notes)
                        <div class="mb-1">
                           <div class="font-bold">Additional Terms:</div> {!! nl2br(e($quotation->notes)) !!}
                        </div>
                    @endif

                    @if($quotation->showValidTill && $quotation->validUntil)
                        <div class="mb-1">
                            <div class="font-bold">Price Valid Until:</div> {{ $quotation->validUntil }}
                        </div>
                    @endif

                    @if($quotation->showTermsOfPayment && $quotation->termsOfPayment)
                        <div class="mb-1">
                            <div class="font-bold">Terms of Payment:</div> {!! nl2br(e($quotation->termsOfPayment)) !!}
                        </div>
                    @endif

                    <div class="mt-2">
                        <div class="font-bold">Notes:</div>
                        1. Above quoted prices are subject to change in the event of changes in prevailing exchange rate, market conditions, duties, taxes and all other importation changes.<br>
                        2. Prices are subject to change without prior notice.<br>
                        3. Above quoted items are NON-CANCELABLE, once confirmed, order is placed.<br>
                        4. Above quoted prices are VAT-inclusive.
                    </div>
                </td>
                <td class="p-1" style="border-top: 1.5px solid #000; border-right: 1.5px solid #000;"></td>
                <td class="p-1" style="border-top: 1.5px solid #000;"></td>
            </tr>
        </tbody>
    </table>
</div>
