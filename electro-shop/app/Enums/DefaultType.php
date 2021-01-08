<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DefaultType extends Enum
{
    const default_limit =   15;
    const default_sort =   'asc';
}
