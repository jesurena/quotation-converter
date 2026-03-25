<div style="width: 100%; font-size: 12px;">
    <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
        <tr>
            <td style="vertical-align: top; width: 65%; padding-right: 20px;">
                <div style="max-width: 85%;">
                    <div style="max-width: 100%; overflow: hidden; display: block; font-size: 10px; text-align: justify;">
                        @if(($quotation->companyCode ?? $quotation->CompanyCode ?? 1) == 2)
                            The above quotation is subject to the terms and conditions of sale printed on the last
                            page. Unless advised of any modification within fifteen (15) days from date this
                            agreement is signed by the Customer, is received by ICS-ICT, the Customer may
                            consider this agreement to have been accepted by ICS-ICT as written with the date
                            received by ICS-ICT as the effective date.
                        @else
                            The above quotation is subject to the terms and conditions of sale printed on the last
                            page. Unless advised of any modification within fifteen(15) days from the date this
                            agreement is signed by the Customer, is received by ICSI, the Customer may consider
                            this agreement to have been accepted by ICSI as written with the date received by ICSI
                            as the effective date.
                        @endif
                    </div>
                </div>

                <div style="margin-top: 32px;">
                    <div style="font-weight: bold; font-size: 11px;">Terms and conditions accepted:</div>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                        <tr>
                            <td style="padding-top: 16px; font-size: 11px;">Customer Name and Signature: _______________________________</td>
                        </tr>
                        <tr>
                            <td style="padding-top: 4px; font-size: 11px;">Date: ____________________________________________________</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="vertical-align: top; font-size: 11px; width: 35%;">
                <strong style="font-weight: bold;">Very Truly Yours,</strong><br><br>
                @if(($quotation->companyCode ?? $quotation->CompanyCode ?? 1) == 2)
                    <strong style="font-weight: bold;">ICS ICT SUPPORT SERVICES CORPORATION</strong>
                @else
                    <strong style="font-weight: bold;">INTEGRATED COMPUTER SYSTEMS, INC.</strong>
                @endif

                <div style="height: 60px;">
                    @if (isset($quoteSignature) && $quoteSignature != '')
                        <img src="{{ $quoteSignature }}" width="128px" height="51px">
                    @endif
                </div>

                <div style="margin-top: 4px;">
                    <strong style="font-weight: bold; text-transform: uppercase;">
                        @php
                            $accountId = null;
                            if (class_exists('Session')) {
                                $userData = Session::get('userData');
                                $accountId = isset($userData[0]->AccountID) ? $userData[0]->AccountID : null;
                            } elseif (function_exists('session')) {
                                $userData = session('userData');
                                $accountId = isset($userData[0]->AccountID) ? $userData[0]->AccountID : null;
                            }
                        @endphp

                        @if($accountId == 56423)
                            FERDIE IBURAN
                        @elseif($accountId == 56549 || $accountId == 56605)
                            MARY NGO
                        @else
                            {{ $quoteSignatory ?? $quotation->signatoryName ?? 'AILEEN DENIÑA' }}
                        @endif
                    </strong>
                </div>
            </td>
        </tr>
    </table>
</div>
