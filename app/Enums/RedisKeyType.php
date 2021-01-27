<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RedisKeyType extends Enum
{
    const Category = 'category_key';
    const Brand = 'brand_key';
}
