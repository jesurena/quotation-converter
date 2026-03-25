<div class="w-full text-base">
    <table class="w-full border-collapse table-fixed">
        <tr>
            <td class="align-top" style="width: 65%; padding-right: 20px;">
                <div class="max-w-85">
                    <div class="max-w-100 overflow-hidden block text-xs text-justify">
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

                <div class="mt-8 text-sm">
                    <div class="font-bold ">Terms and conditions accepted:</div>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                        <tr>
                            <td class="pt-4">Customer Name and Signature: _______________________________</td>
                        </tr>
                        <tr>
                            <td class="pt-1">Date: ____________________________________________________</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td class="align-top text-sm" style="width: 35%;">
                <strong class="font-bold">Very Truly Yours,</strong><br><br>
                @if(($quotation->companyCode ?? $quotation->CompanyCode ?? 1) == 2)
                    <strong class="font-bold">ICS ICT SUPPORT SERVICES CORPORATION</strong>
                @else
                    <strong class="font-bold">INTEGRATED COMPUTER SYSTEMS, INC.</strong>
                @endif

                <div style="height: 60px;">
                    @if (isset($quoteSignature) && $quoteSignature != '')
                        <img src="{{ $quoteSignature }}" width="128px" height="51px">
                    @endif
                </div>

                <div class="mt-1">
                    <strong class="font-bold uppercase">
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
