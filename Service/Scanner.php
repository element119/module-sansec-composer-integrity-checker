<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Service;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Sansec\Integrity\PackageResolver\LockReaderStrategyFactory;
use Sansec\Integrity\PackageSubmitterFactory;
use Symfony\Component\Console\Output\NullOutputFactory;

class Scanner
{
    public function __construct(
        private readonly DirectoryList $directoryList,
        private readonly LockReaderStrategyFactory $lockReaderFactory,
        private readonly NullOutputFactory $nullOutputFactory,
        private readonly PackageSubmitterFactory $scannerFactory,
    ) {}

    /**
     * @return array
     * @throws FileSystemException
     */
    public function scan(): array
    {
        $lockReader = $this->lockReaderFactory->create([
            'rootDirectory' => $this->directoryList->getPath(DirectoryList::ROOT),
        ]);
        $scanner = $this->scannerFactory->create([
            'packageResolverStrategy' => $lockReader,
        ]);
        $output = $this->nullOutputFactory->create();

        return $scanner->getPackageVerdicts($output);
    }
}
