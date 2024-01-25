<?php

namespace CReifenscheid\SiteSetup\ViewHelpers;

use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * A ViewHelper to create skip links.
 *
 * Examples
 * ========
 *
 * Default
 * -------
 *
 * ::
 *
 *    <siteSetup:skipButton additionalClasses="my-class" targetId="elementId">Label</siteSetup:skipButton>
 *
 * Output::
 *
 *    <a class="skip-button my-class" href="#elementId">Label</a>
 *
 */
class SkipButtonViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('targetId', 'string', 'ID of the element to skip to', true);
        $this->registerArgument('value', 'string', 'Link text of the generated link');
        $this->registerArgument('additionalClasses', 'string', 'Additional css classes', false);
        $this->registerArgument('tabindex', 'integer', 'Index in tabing order');
    }

    public function render(): string
    {
        // define tag attribute values
        $cssClasses = 'skip-button';

        if($this->arguments['additionalClasses']) {
            $cssClasses .= ' '.$this->arguments['additionalClasses'];
        }

        // assign tag attributes
        $this->tag->addAttribute('class', $cssClasses);

        if ($this->arguments['tabindex']) {
            $this->tag->addAttribute('tabindex', $this->arguments['tabindex']);
        }

        $uri = $_SERVER['REQUEST_URI'] !== '/' ? $_SERVER['REQUEST_URI'] : '';
        $this->tag->addAttribute('href', $uri . '#' . $this->arguments['targetId']);

        if (!empty($this->renderChildren())) {
            $this->tag->setContent($this->renderChildren());
        } elseif (!empty($this->arguments['value'])) {
            $this->tag->setContent($this->arguments['value']);
        } else {
            $this->tag->setContent(LocalizationUtility::translate('LLL:EXT:site_setup/Resources/Private/Language/locallang.xlf:skipToContent'));
        }

        $this->tag->forceClosingTag(true);

        return $this->tag->render();
    }
}
