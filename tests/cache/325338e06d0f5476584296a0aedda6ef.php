<div style="z-index: 1000; padding-top: 0;">
    <div style="text-align: center; margin-bottom: 32px;">
        <b style="text-transform: uppercase; font-size: 20px;">TERMS AND CONDITIONS</b>
    </div>

    <table style="width: 100%; border-collapse: collapse; table-layout: fixed; border-spacing: 16px 0;">
        <tr>
            <td style="vertical-align: top; font-size: 11px; text-align: justify; width: 50%; padding-right: 16px; line-height: 1.5; letter-spacing: 0.4px;">
                <p>Integrated Computer Systems, Inc. ("ICSI") agrees to sell, and the 
                "Customer" agrees to accept on the following terms and conditions of
                the product(s) listed on the other side of this agreement. The customer
                also agrees with respect to the product(s) and any other accessories or 
                service uses with the product(s) to carry and accept the responsibility for 
                1) their acquisition and choice to satisfy the Customer's intended
                output, 2) their use, and 3) the output obtained there from.</p>

                <p style="><strong style="font-weight: bold;">PRICE SPECIFICATION</strong></p>
                <p>Every effort shall be made by ICSI to protect the prices stated herein. 
                However, ICSI shall reserve the right to subject the quoted prices to 
                change without prior notice in case of fortuitous events and prevailing
                market conditions at the time of delivery (i.e. inflation, devaluation,
                government impose rulings, deflation, etc.).</p>

                <p style="><strong style="font-weight: bold;">PAYMENT DELIVERY</strong></p>
                <p>Unless otherwise agreed upon in writing, payment for products shall be made:</p>

                <?php if (in_array((int)$quotation->id, [1087338, 1088239, 1088235, 1088233, 1087339, 1088792, 1087341, 1088159, 1088155, 1088162])): ?>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Due after 60 days</p>
                <?php
else: ?>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. 50% down payment upon acceptance of agreement</p>
                    <?php if ($quotation->signatoryId == 56220): ?>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Balance settlement prior/before delivery</p>
                    <?php
    else: ?>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Balance due upon delivery</p>   
                    <?php
    endif; ?>
                <?php
endif; ?>

                <p>All products described in this Agreement shall remain the property of 
                ICSI and shall not be disposed of or encumbered in any manner by 
                the Customer until fully paid for.</p>

                <p>The Customer assumes the risk of loss or damage upon delivery of the 
                product(s) to the Customer.</p>

                <p>Delivery dates are approximate; ICSI shall not be liable for delay in 
                delivery due to causes beyond its reasonable control.</p>

                <p style="><strong style="font-weight: bold;">WARRANTY</strong></p>
                <p>ICSI warrants that each new product sold shall be free from defects, 
                flaws and damages in material, performance, workmanship and 
                construction for a period of one (1) year or for periods as stated on the
                proposal thereof, except for batteries, detachable and consumables
                which may be contained therein, and that when used in accordance with
                its normal use from the date of delivery.</p>

                <p>If examination by ICSI discloses that the product has been defective, 
                then its obligation is limited to repair or replacement, at its sole</p>
            </td>

            <td style="vertical-align: top; font-size: 11px; text-align: justify; width: 50%; padding-left: 16px; line-height: 1.5; letter-spacing: 0.4px;">
                <p>
                discretion, of the defective unit or its components. ICSI is not responsible for products which have been subject to misuse, alteration, 
                accident or for repairs not performed by ICSI. 
                ICSI shall not be responsible for any incidental
                or consequential damages arising from any 
                breach of warranty.</p>

                <p style="><strong style="font-weight: bold;">PROGRAM PRODUCT LICENSES</strong></p>
                <p>Any program products (software) listed on this agreement are not sold
                and ownership of or title to program products does not pass to 
                Customer. Customer purchases only a non-exclusive license to use 
                program products (software).</p>

                <p style="><strong style="font-weight: bold;">DEFAULT</strong></p>
                <p>If the Customer fails to pay any amount due to ICSI or breaches any
                of the terms of this agreement, 
                ICSI may, in addition to any legal
                remedies it may have, forfeit the down payment of Customer and or at 
                the option of ICSI, sell the products to third parties, discontinue all 
                services of the equipment, including warranty service, 
                service under a 
                maintenance agreement or any other type of service.</p>

                <p>Any court litigation arising from the agreement shall either be instituted
                in the proper 
                court of San Juan City or at the option of ICSI. Should
                ICSI resort to a court suit, the 
                Customer shall, in addition,
                to its 
                responsibilities under this Agreement and applicable laws, pay ICSI, 
                attorney's 
                fees of 25% of the amount due to ICSI, but in no case less 
                than P1,000.00 and cost of the suit. Interest at the maximum
                rate per 
                annum allowable by law shall be charged on all overdue accounts.</p>

                <p style="font-weight: bold; ">MISCELLANEOUS</p>
                <p>No waiver, alteration, or modification of any of the provisions 
                hereof
                shall be binding upon ICSI unless in writing and signed by 
                duly 
                authorized representative of ICSI and Customer. All drawings,
                designs,
                techniques and improvements whether patentable made or 
                conceived by ICSI or 
                its agent or employees in fulfillment of this 
                agreement shall be the property of
                ICSI, and Customer agrees not to 
                use for its own
                benefit, or disclose to, or use for the benefit of any other 
                person any of such 
                property. The Customer may not assign his right or 
                duties under this agreement
                including the rights to benefit from the 
                warranty
                contained herein without the prior written consent of ICSI,
                which consent shall 
                not unreasonably be withheld. ICSI shall not be responsible for failure to render service 
                due to strikes, fire, flood, and other
                causes beyond its control.</p>
            </td>
        </tr>
    </table>
</div><?php /**PATH C:\Projects\quotation-converter/resources/views/components/terms.blade.php ENDPATH**/?>