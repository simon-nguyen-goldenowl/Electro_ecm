<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ESIndexType extends Enum
{
    const ProductIndex = 'products';
    const CategoryIndex = 'categories';
    const BrandIndex = 'brands';
}
