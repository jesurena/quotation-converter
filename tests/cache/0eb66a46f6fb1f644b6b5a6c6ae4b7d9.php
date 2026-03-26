
<div style="width: 100%;">
    <table style="width: 100%; border-collapse: collapse; font-family: 'Times New Roman', serif; font-size: 11px;">
        <thead style="display: table-header-group;">
            <tr>
                <th colspan="4" style="border: none; padding: 0; padding-bottom: 10px; font-weight: normal; text-align: left; vertical-align: top;">
                    <?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

        <?php $count = count($quotation->lineItems); ?>
        <?php $__currentLoopData = $quotation->lineItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php 
                // Normalize newlines and HTML line breaks to \n
                $descRaw = preg_replace('/<br\s*\/?>/i', "\n", $item->description);
                $descRaw = str_replace(["\r\n", "\r"], "\n", $descRaw);
                $descLines = explode("\n", $descRaw);
            ?>

            <?php $__currentLoopData = $descLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lineIndex => $descLine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $trimmedLine = trim($descLine); 
                    $pt = $lineIndex === 0 ? '4px' : '0';
                    $pb = $lineIndex === (count($descLines) - 1) ? '8px' : '0';
                ?>
                <tr>
                    <td style="padding-left: 4px; padding-right: 4px; text-align: center; vertical-align: top; font-size: 11px; border-left: 1.5px solid #000; border-right: 1.5px solid #000; padding-top: <?php echo e($pt); ?>; padding-bottom: <?php echo e($pb); ?>;">
                        <?php if($lineIndex === 0): ?>
                            <?php echo e(number_format($item->quantity)); ?>

                        <?php endif; ?>
                    </td>
                    <td style="padding-left: 4px; padding-right: 4px; vertical-align: top; font-size: 11px; border-right: 1.5px solid #000; padding-top: <?php echo e($pt); ?>; padding-bottom: <?php echo e($pb); ?>;">
                        <div style="line-height: 1.4;"><?php echo $trimmedLine === '' ? '&nbsp;' : nl2br(e($descLine)); ?></div>
                    </td>
                    <td style="padding-left: 4px; padding-right: 4px; text-align: right; vertical-align: top; font-size: 11px; border-right: 1.5px solid #000; padding-top: <?php echo e($pt); ?>; padding-bottom: <?php echo e($pb); ?>;">
                        <?php if($lineIndex === 0 && $item->showItemPrices): ?>
                            <?php echo e(number_format($item->unitPrice, 2)); ?>

                        <?php endif; ?>
                    </td>
                    <td style="padding-left: 4px; padding-right: 4px; text-align: right; vertical-align: top; font-size: 11px; border-right: 1.5px solid #000; padding-top: <?php echo e($pt); ?>; padding-bottom: <?php echo e($pb); ?>;">
                        <?php if($lineIndex === 0 && $item->showItemPrices): ?>
                            <?php echo e(number_format($item->totalPrice, 2)); ?>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <tr>
                <td style="padding: 4px; border-left: 1.5px solid #000; border-right: 1.5px solid #000;"></td>
                <td style="padding: 4px; border-right: 1.5px solid #000;"></td>
                <td style="padding: 4px; text-align: right; font-weight: bold; font-size: 12px; border-right: 1.5px solid #000;">Total <?php echo e($quotation->currency); ?></td>
                <td style="padding: 4px; text-align: right; font-weight: bold; font-size: 11px; border-right: 1.5px solid #000;">
                    <?php echo e(number_format($quotation->totals->grandTotal, 2)); ?>

                </td>
            </tr>

            <tr>
                <td style="padding: 4px; border-right: 1.5px solid #000; border-bottom: 1.5px solid #000; border-left: 1.5px solid #000;"></td>
                <td style="vertical-align: top; font-size: 10px; border-right: 1.5px solid #000; border-bottom: 1.5px solid #000; padding: 8px;">
                    <?php if($quotation->showWarranty && $quotation->warranty): ?>
                        <div style="margin-bottom: 4px;">
                            <div style="font-weight: bold;">Warranty:</div> <?php echo nl2br(e($quotation->warranty)); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($quotation->showAvailability && $quotation->availability): ?>
                        <div style="margin-bottom: 4px;">
                            <div style="font-weight: bold;">Availability:</div> <?php echo nl2br(e($quotation->availability)); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($quotation->showSpecialNotes && $quotation->notes): ?>
                        <div style="margin-bottom: 4px;">
                           <div style="font-weight: bold;">Additional Terms:</div> <?php echo nl2br(e($quotation->notes)); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($quotation->showValidTill && $quotation->validUntil): ?>
                        <div style="margin-bottom: 4px;">
                            <div style="font-weight: bold;">Price Valid Until:</div> <?php echo e($quotation->validUntil); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($quotation->showTermsOfPayment && $quotation->termsOfPayment): ?>
                        <div style="margin-bottom: 4px;">
                            <div style="font-weight: bold;">Terms of Payment:</div> <?php echo nl2br(e($quotation->termsOfPayment)); ?>

                        </div>
                    <?php endif; ?>

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
<?php /**PATH C:\Projects\quotation-converter\resources\views/components/quotation_table.blade.php ENDPATH**/ ?>