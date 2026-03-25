<div class="w-full">
    <table class="w-full border-collapse table-fixed">
        <tr>
            <td class="align-top" style="width: 8%;">
                <?php if($quotation->company->logo): ?>
                    <img src="<?php echo e($quotation->company->logo); ?>" style="width: 65px; height: auto; margin-left: -10px; margin-top: -5px;">
                <?php endif; ?>
            </td>
            <td class="align-top" style="width: 62%;">
                <div class="font-bold uppercase text-2xl">INTEGRATED COMPUTER SYSTEMS, INC.</div>
                <div class="text-xs" style="color: #333;">
                    3/F Limketkai Building, Ortigas Avenue<br>
                    San Juan, Metro Manila, 1502 Philippines
                </div>
            </td>
            <td class="align-top text-right text-xs" style="width: 30%;">
                Tel. No. (+632) 8689-5000<br>
                Fax No. (+632) 8721-4502<br>
                Email: info@ics.com.ph<br>
                Web: www.ics.com.ph
            </td>
        </tr>
    </table>
    <div class="w-full mb-3">
        <table class="w-full border-collapse table-fixed">
            <tr>
                <td class="align-top" style="width: 60%;">
                    <div class="font-bold uppercase text-lg"><?php echo e($quotation->client->name); ?></div>
                    <div class="text-base" style="line-height: 1.3;">
                        <?php echo nl2br(e($quotation->client->address)); ?>

                    </div>
                    <br>
                    <?php if($quotation->client->contactPerson): ?>
                        <div class="font-bold uppercase text-base">ATTN : <?php echo e($quotation->client->contactPerson); ?></div>
                    <?php endif; ?>
                </td>
                <td class="align-top text-base" style="width: 35%; text-align: right;">
                    <div style="display: inline-block; text-align: left;">
                        <div>Date: <?php echo e($quotation->date); ?></div>
                        <div>Ref.No: <?php echo e($quotation->id); ?></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="mb-1 text-base">
        <span class="uppercase">GENTLEMEN:</span> We are pleased to submit for your kind consideration and approval our quotation for the following items.
    </div>
</div>
<?php /**PATH C:\Projects\quotation-converter\resources\views/components/header.blade.php ENDPATH**/ ?>