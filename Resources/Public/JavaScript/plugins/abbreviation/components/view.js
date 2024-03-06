import {Core, UI} from "@typo3/ckeditor5-bundle.js";
import L10n from "./l10n.js";

export default class FormView extends UI.View {
    constructor (locale) {
        super(locale);

        this.l10n = new L10n(locale);

        // Input fields
        this.abbrInputView = this._createInput(this.l10n.locale('labelAbbr', 'Add abbreviation'));
        this.titleInputView = this._createInput(this.l10n.locale('labelTitle', 'Add title'));

        // Buttons
        this.saveButtonView = this._createButton(
            'Save', Core.icons.check, 'ck-button-save'
        );
        this.saveButtonView.type = 'submit';

        this.cancelButtonView = this._createButton(
            'Cancel', Core.icons.cancel, 'ck-button-cancel'
        );
        // Delegate ButtonView#execute to FormView#cancel
        this.cancelButtonView.delegate('execute').to(this, 'cancel');

        this.childViews = this.createCollection([
            this.abbrInputView,
            this.titleInputView,
            this.saveButtonView,
            this.cancelButtonView
        ]);

        // Template
        this.setTemplate({
            tag: 'form',
            attributes: {
                class: ['ck', 'ck-abbr-form'],
                tabindex: '-1'
            },
            children: this.childViews
        });
    }

    render () {
        super.render();

        // Submit the form when the user clicked the save button or pressed enter in the input.
        UI.submitHandler({
            view: this
        });
    }

    focus () {
        this.childViews.first.focus();
    }

    _createInput (label) {
        const labeledInput = new UI.LabeledFieldView(this.locale, UI.createLabeledInputText);

        labeledInput.label = label;

        return labeledInput;
    }

    _createButton (label, icon, className) {
        const button = new UI.ButtonView();

        button.set({
            label,
            icon,
            tooltip: true,
            class: className
        });

        return button;
    }
}