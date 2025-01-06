<?php

namespace App\Services;

class ColourService
{
    protected array $calculated = [];

    /**
     * Get a contrasting colour, either black or white depending on the provided colour
     */
    public function contrastBW(string $colour): string
    {
        $hexColour = mb_trim($colour, '#');
        // Don't re-check already calculated values
        if (isset($this->calculated[$hexColour])) {
            return $this->calculated[$hexColour];
        }

        // hexColour RGB
        $R1 = hexdec(mb_substr($hexColour, 1, 2));
        $G1 = hexdec(mb_substr($hexColour, 3, 2));
        $B1 = hexdec(mb_substr($hexColour, 5, 2));

        // Black RGB
        $blackColour = "#000000";
        $R2BlackColour = hexdec(mb_substr($blackColour, 1, 2));
        $G2BlackColour = hexdec(mb_substr($blackColour, 3, 2));
        $B2BlackColour = hexdec(mb_substr($blackColour, 5, 2));

        // Calc contrast ratio
        $L1 = 0.2126 * pow($R1 / 255, 2.2) +
            0.7152 * pow($G1 / 255, 2.2) +
            0.0722 * pow($B1 / 255, 2.2);

        $L2 = 0.2126 * pow($R2BlackColour / 255, 2.2) +
            0.7152 * pow($G2BlackColour / 255, 2.2) +
            0.0722 * pow($B2BlackColour / 255, 2.2);

        $contrastRatio = 0;
        if ($L1 > $L2) {
            $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
        } else {
            $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
        }

        // If contrast is more than 5, return black colour
        if ($contrastRatio > 5) {
            return $this->calculated[$hexColour] = '#000000';
        } else {
            return $this->calculated[$hexColour] = '#FFFFFF';
        }
    }
}
