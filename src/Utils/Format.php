<?php

declare(strict_types=1);

namespace Quotation\Converter\Utils;

/**
 * Utility helper for formatting quotation content.
 */
class Format
{
    /**
     * Format a multi-line description string for HTML output.
     * Often, the first line is the product title/main description.
     */
    public static function description(string $description): string
    {
        if (empty(trim($description))) {
            return '';
        }

        // Standardize line endings
        $description = str_replace(["\r\n", "\r"], "\n", $description);
        $lines = explode("\n", $description);
        
        // Remove empty trailing lines
        while (!empty($lines) && trim(end($lines)) === '') {
            array_pop($lines);
        }

        if (empty($lines)) {
            return '';
        }

        // The first line is usually the main product name/PN, make it bold
        $firstLine = array_shift($lines);
        $formatted = '<strong>' . e($firstLine) . '</strong>';

        if (!empty($lines)) {
            // Join the rest with <br> and escape them
            $rest = implode("\n", $lines);
            if (trim($rest) !== '') {
                $formatted .= '<br>' . nl2br(e($rest));
            }
        }

        return $formatted;
    }
}
