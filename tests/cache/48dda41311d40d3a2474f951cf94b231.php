<div style="width: 100%;">
    <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
        <tr>
            <td style="vertical-align: top; width: 8%;">
                <?php if($quotation->company->logo): ?>
                    <img src="<?php echo e($quotation->company->logo); ?>" style="width: 65px; height: auto; margin-left: -10px; margin-top: -10px;">
                <?php endif; ?>
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
                    <div style="font-weight: bold; text-transform: uppercase; font-size: 13px;"><?php echo e($quotation->client->name); ?></div>
                    <div style="font-size: 11px; line-height: 1.3;">
                        <?php echo nl2br(e($quotation->client->address)); ?>

                    </div>
                    <br>
                    <?php if($quotation->client->contactPerson): ?>
                        <div style="font-weight: bold; text-transform: uppercase; font-size: 11px;">ATTN : <?php echo e($quotation->client->contactPerson); ?></div>
                    <?php endif; ?>
                </td>
                <td style="vertical-align: top; font-size: 11px; width: 35%; text-align: right;">
                    <div style="display: inline-block; text-align: left;">
                        <div>Date: <?php echo e($quotation->date); ?></div>
                        <div>Ref.No: <?php echo e($quotation->id); ?></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 4px; font-size: 11px;">
        <span style="text-transform: uppercase;">GENTLEMEN:</span> We are pleased to submit for your kind consideration and approval our quotation for the following items.
    </div>
</div>
<?php /**PATH C:\Projects\quotation-converter/resources/views/components/header.blade.php ENDPATH**/ ?>