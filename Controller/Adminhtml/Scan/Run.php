<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Controller\Adminhtml\Scan;

use Element119\SansecComposerIntegrityChecker\Service\Scanner;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Run extends Action
{
    public const ADMIN_RESOURCE = 'Element119_SansecComposerIntegrityChecker::run';

    private Scanner $scanner;

    public function __construct(
        Context $context,
        Scanner $scanner
    ) {
        parent::__construct($context);

        $this->scanner = $scanner;
    }

    public function execute()
    {
        $results = $this->scanner->scan();

        if ($results) {
            $this->messageManager->addSuccessMessage(__('Scan complete.'));
        } else {
            $this->messageManager->addErrorMessage(__('Could not scan packages.'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sansec_composer_integrity_checker/index/index');

        return $resultRedirect;
    }
}
