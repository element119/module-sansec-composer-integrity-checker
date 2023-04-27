<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Controller\Adminhtml\Scan;

use Element119\SansecComposerIntegrityChecker\Model\IntegrityResultsRegistry;
use Element119\SansecComposerIntegrityChecker\Service\Scanner;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\FileSystemException;

class Run extends Action
{
    public const ADMIN_RESOURCE = 'Element119_SansecComposerIntegrityChecker::run';

    private IntegrityResultsRegistry $integrityResultsRegistry;
    private Scanner $scanner;

    public function __construct(
        Context $context,
        IntegrityResultsRegistry $integrityResultsRegistry,
        Scanner $scanner
    ) {
        parent::__construct($context);

        $this->integrityResultsRegistry = $integrityResultsRegistry;
        $this->scanner = $scanner;
    }

    /**
     * @throws FileSystemException
     * @throws Exception
     */
    public function execute(): ResultInterface
    {
        $results = $this->scanner->scan();

        if ($results) {
            $this->integrityResultsRegistry->setResults($results);
            $this->messageManager->addSuccessMessage(__('Scan complete.'));
        } else {
            $this->messageManager->addErrorMessage(__('Could not scan packages.'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sansec_composer_integrity_checker/index/index');

        return $resultRedirect;
    }
}
