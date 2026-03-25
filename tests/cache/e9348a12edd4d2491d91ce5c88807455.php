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

    .w-full { width: 100%; }
    .border-collapse { border-collapse: collapse; }
    .text-center { text-align: center; }
    .text-justify { text-align: justify; }
    .font-bold { font-weight: bold; }
    .uppercase { text-transform: uppercase; }
    .mb-8 { margin-bottom: 32px; }
    .align-top { vertical-align: top; }
    
    .text-4xl { font-size: 26px; }
    .text-sm { font-size: 11px; }
    
    /* Specific styles for terms component if not already there */
    p { margin-bottom: 10px; }
</style>

<div class="terms-page">
    <?php echo $__env->make('quotation-pkg::components.terms', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php /**PATH C:\Projects\quotation-converter/resources/views/pdf_terms.blade.php ENDPATH**/ ?>