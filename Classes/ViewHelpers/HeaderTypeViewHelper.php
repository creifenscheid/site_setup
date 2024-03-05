<?php

namespace CReifenscheid\SiteSetup\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

use function preg_match;

class HeaderTypeViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('contentData', 'array', 'Data of the plugin tt_content element', true);
    }

    public function render(): ?int
    {
        $contentData = $this->arguments['contentData'];
        $headerLayout = (int)$contentData['header_layout'];
        $defaultHeaderType = $this->getDefaultHeaderType();

        if ($headerLayout === 100) {
            return $defaultHeaderType;
        }

        $baseHeaderType = $headerLayout === 0 ? $defaultHeaderType : $headerLayout;
        $subheader = $contentData['subheader'];

        // no subheader to respect
        if ($subheader === '') {
            return $baseHeaderType + 1;
        }

        return $baseHeaderType + 2;
    }

    private function getDefaultHeaderType(): ?int
    {
        foreach ($GLOBALS['TSFE']->tmpl->constants as $constants) {
            preg_match('/defaultHeaderType = ([1-6]+)/', (string)$constants, $output);

            if ($output !== []) {
                return (int)$output[1];
            }
        }

        return null;
    }
}
