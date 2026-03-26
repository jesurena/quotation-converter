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

    @page {
        margin: 100px 50px 100px 50px; /* top right bottom left */
    }

    header {
        position: fixed;
        top: -80px; /* adjust based on margin */
        left: 0;
        right: 0;
        height: 80px;
    }

    footer {
        position: fixed;
        bottom: -80px;
        left: 0;
        right: 0;
        height: 80px;
    }

    /* Force page breaks between sections */
    .page {
        page-break-after: always;
    }

    /* Hide header/footer for Terms page */
    .no-header-footer header,
    .no-header-footer footer {
        display: none;
    }

    .no-header-footer {
        page-break-before: always; /* ensure Terms starts on a new page */
        margin: 50px; /* optional: smaller margin */
        position: relative;
    }

    /* Reliable Dompdf hack: Mask fixed header/footer on this page with white boxes */
    .no-header-footer::before {
        content: "";
        position: fixed;
        top: -100px;
        left: -50px;
        right: -50px;
        height: 100px;
        background: white;
        z-index: 1000;
    }

    .no-header-footer::after {
        content: "";
        position: fixed;
        bottom: -100px;
        left: -50px;
        right: -50px;
        height: 100px;
        background: white;
        z-index: 1000;
    }

    .pagenum:before {
        content: counter(page);
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

<?php /**PATH C:\Projects\quotation-converter/resources/views/style.blade.php ENDPATH**/ ?>