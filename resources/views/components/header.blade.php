<div style="width: 100%;">
    <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
        <tr>
            <td style="vertical-align: top; width: 8%;">
                @if($quotation->company->logo)
                    <img src="{{ $quotation->company->logo }}" style="width: 65px; height: auto; margin-left: -10px; margin-top: -10px;">
                @endif
            </td>
            <td style="vertical-align: top; width: 62%;">
                <div style="font-weight: bold; text-transform: uppercase; font-size: 17px;">INTEGRATED COMPUTER SYSTEMS, INC.</div>
                <div style="font-size: 10px; color: #333;">
                    3/F Limketkai Building, Ortigas Avenue<br>
                    San Juan, Metro Manila, 1502 Philippines
                </div>
            </td>
            <td style="vertical-align: top; text-align: right; font-size: 10px; width: 30%;">
                Tel. No. (+632) 8689-5000<br>
                Fax No. (+632) 8721-4502<br>
                Email: info@ics.com.ph<br>
                Web: www.ics.com.ph
            </td>
        </tr>
    </table>
    <div style="width: 100%; margin-bottom: 12px;">
        <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
            <tr>
                <td style="vertical-align: top; width: 60%;">
                    <div style="font-weight: bold; text-transform: uppercase; font-size: 13px;">{{ $quotation->client->name }}</div>
                    <div style="font-size: 11px; line-height: 1.3;">
                        {!! nl2br(e($quotation->client->address)) !!}
                    </div>
                    <br>
                    @if($quotation->client->contactPerson)
                        <div style="font-weight: bold; text-transform: uppercase; font-size: 11px;">ATTN : {{ $quotation->client->contactPerson }}</div>
                    @endif
                </td>
                <td style="vertical-align: top; font-size: 11px; width: 35%; text-align: right;">
                    <div style="display: inline-block; text-align: left;">
                        <div>Date: {{ $quotation->date }}</div>
                        <div>Ref.No: {{ $quotation->id }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 4px; font-size: 11px;">
        <span style="text-transform: uppercase;">GENTLEMEN:</span> We are pleased to submit for your kind consideration and approval our quotation for the following items.
    </div>
</div>
