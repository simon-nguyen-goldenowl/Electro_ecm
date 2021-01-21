<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ESStatusType extends Enum
{
    const IsNotSynced = 0;
    const IsSynced = 1;
    const IsUpdated = 2;
}
