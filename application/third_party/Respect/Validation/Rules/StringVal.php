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

class StringVal extends AbstractRule
{
    public function validate($input)
    {
        return is_scalar($input) || (is_object($input) AND method_exists($input, '__toString'));
    }
}
