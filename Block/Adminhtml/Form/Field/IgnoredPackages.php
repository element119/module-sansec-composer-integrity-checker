<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class IgnoredPackages extends AbstractFieldArray
{
    public const PACKAGE = 'package';

    /**
     * @inheritDoc
     */
    protected function _prepareToRender(): void
    {
        // package name column index
        $this->addColumn(
            self::PACKAGE,
            [
                'label' => __('Package'),
                'class' => 'required-entry',
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Package');
    }
}
