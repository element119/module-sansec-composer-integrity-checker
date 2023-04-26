<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Service;

use DI\Container;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Sansec\Integrity\PackageResolver\LockReaderStrategy;
use Sansec\Integrity\PackageSubmitter;
use Symfony\Component\Console\Output\NullOutput;

class Scanner
{
    public function __construct(
        private readonly Container $diContainer,
        private readonly DirectoryList $directoryList,
    ) {}

    /**
     * @return array
     * @throws FileSystemException
     */
    public function scan(): array
    {
        $scanner = $this->diContainer->make(
            PackageSubmitter::class,
            [
                'packageResolverStrategy' => $this->diContainer->make(
                    LockReaderStrategy::class,
                    ['rootDirectory' => $this->directoryList->getPath(DirectoryList::ROOT)]
                )
            ]
        );

        return $scanner->getPackageVerdicts($this->diContainer->make(NullOutput::class));
    }
}
