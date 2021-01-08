<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusType extends Enum
{
    const OrderType =   'O';
    const ShippingType =   'S';
    const PaymentType = 'T';
}
