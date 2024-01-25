<?php

namespace CReifenscheid\SiteSetup\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

use function preg_match;

/**
 * Class HeaderTypeViewHelper
 *
 * This viewhelper returns the header type to use based on the header layout of the given content element.
 * E.g. the content element header_layout is set to 3, so a h3 header is rendered, the next header type has to be h4 without existing subheader or h5 with existing subheader. By returning this header type, hard-coded but well-structured headlines can be achieved.
 *
 * If the content elements header type is set to default or hidden, TYPO3s configured default header is used as calculation base.
 *
 * Examples
 * ========
 *
 * <namespace:headerType contentData='{dataArray}' />
 */
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
