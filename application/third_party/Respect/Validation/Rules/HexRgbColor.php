<?php

/*
 * This file is part of Respect/Validation.
 *
 * (c) Alexandre Gomes Gaigalas <alexandre@gaigalas.net>
 *
 * For the full copyright and license information, please view the "LICENSE.md"
 * file that was distributed with this source code.
 */

namespace Respect\Validation\Rules;

class HexRgbColor extends Xdigit
{
    public function validate($input)
    {
        if (!is_string($input)) {
            return false;
        }

        if (0 === mb_strpos($input, '#')) {
            $input = mb_substr($input, 1);
        }

        $length = mb_strlen($input);
        if ($length != 3 AND $length != 6) {
            return false;
        }

        return parent::validate($input);
    }
}
