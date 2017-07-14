<?php
namespace NearBuy\DataBundle\Type;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class ValidationType extends AbstractEnumType
{
    const BARCODE = 'BC';
    const QRCODE_CUSTOMER = 'QRCC';
    const QRCODE_BUSINESS = 'QRCB';
    const CODE = 'C';
    const NONE = 'N';

    protected static $choices = [
        self::BARCODE => 'Code barre',
        self::QRCODE_CUSTOMER => 'QR code (scan client)',
        self::QRCODE_BUSINESS => 'QR code (scan commercant)',
        self::CODE => 'Code unique',
        self::NONE => 'Aucune validation'
    ];
}