<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Service;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Symfony\Component\Process\Process;

class Scanner
{
    public function __construct(private readonly DirectoryList $directoryList) {}

    /**
     * @return array
     * @throws FileSystemException
     */
    public function scan(): array
    {
        $output = '';
        $process = new Process($this->getCommandOptionsArray());
        $process->run();

        foreach ($process as $data) {
            $output .= $data;
        }

        $output = substr($output, 0, strpos($output, ']') + 1); // json output only

        return json_decode($output, true);
    }

    /**
     * @throws FileSystemException
     */
    public function getCommandOptionsArray(): array
    {
        return [
            'composer',
            'integrity',
            '--json',
            '--no-ansi',
            '--no-interaction',
            sprintf('--working-dir=%s', $this->directoryList->getPath(DirectoryList::ROOT)),
        ];
    }
}
