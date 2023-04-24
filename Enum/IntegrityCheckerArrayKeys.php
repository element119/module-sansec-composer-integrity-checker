<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Enum;

enum IntegrityCheckerArrayKeys: string
{
    case Checksum = 'checksum';
    case Package = 'package';
    case PackageId = 'package_id';
    case Percentage = 'percentage';
    case Status = 'status';
    case Version = 'version';
}
