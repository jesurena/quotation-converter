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
<?php /**PATH C:\Projects\quotation-converter\resources\views/components/letterhead.blade.php ENDPATH**/ ?>