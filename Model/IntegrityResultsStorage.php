<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\SansecComposerIntegrityChecker\Model;

use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Flag;

class IntegrityResultsStorage extends Flag
{
    protected $_flagCode = 'sansec_composer_integrity_checker_results';

    public function getLastResults(): ?array
    {
        try {
            return $this->loadSelf()->getFlagData();
        } catch (LocalizedException $e) {
            return [];
        }
    }

    /**
     * @throws Exception
     */
    public function setResults(array $data): self
    {
        $this->setFlagData($data);

        return $this->save();
    }
}
