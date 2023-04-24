<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class ComposerIntegrityNotificationEmailRecipients extends AbstractFieldArray
{
    public const CSV_REPORT_EMAIL_ADDRESS = 'email_address';

    /**
     * @inheritDoc
     */
    protected function _prepareToRender(): void
    {
        // CSV column index
        $this->addColumn(
            self::CSV_REPORT_EMAIL_ADDRESS,
            [
                'label' => __('Email Address'),
                'class' => 'required-entry',
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Email Address');
    }
}
