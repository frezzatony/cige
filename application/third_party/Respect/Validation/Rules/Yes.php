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

class Yes extends Regex
{
    public function __construct($useLocale = false)
    {
        $pattern = '^y(eah?|ep|es)?$';
        if ($useLocale AND defined('YESEXPR')) {
            $pattern = nl_langinfo(YESEXPR);
        }

        parent::__construct('/'.$pattern.'/i');
    }
}
