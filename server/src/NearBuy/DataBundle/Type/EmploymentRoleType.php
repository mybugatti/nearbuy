<?php
namespace NearBuy\DataBundle\Type;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class EmploymentRoleType extends AbstractEnumType
{
    const CASHIER = 'cash';
    const COMMERCIAL = 'com';
    const CEO = 'ceo';

    protected static $choices = [
        self::CASHIER => 'Cashier',
        self::COMMERCIAL => 'Commercial',
        self::CEO => 'Chief',
    ];
}