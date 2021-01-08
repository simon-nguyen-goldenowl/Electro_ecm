<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ShippingStatusType extends Enum
{
    const Shipping =   6;
    const Shipped =   7;
}
