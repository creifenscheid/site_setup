import { stringifyLanguageAttribute } from './utils.js';
import * as UI from"@ckeditor/ckeditor5-ui";
import * as Core from"@ckeditor/ckeditor5-core";
import * as Utils from"@ckeditor/ckeditor5-utils"
import L10n from "./l10n.js";

export default class TextPartLanguageUI extends Core.Plugin {

    static get pluginName() {
        return 'TextPartLanguageUI';
    }

    init() {
        const editor = this.editor;
        const options = editor.config.get('language.textPartLanguage');
        const l10n = new L10n(editor.config.get('language'));

        const removeTitle = l10n.locale('langRemove', 'Remove language');
        const accessibleLabel = l10n.locale('dropdownLabel', 'Set language for selection');

        // Register UI component.
        editor.ui.componentFactory.add('textPartLanguage', locale => {
            const itemDefinitions = new Utils.Collection();
            const titles = {};
            const languageCommand = editor.commands.get('textPartLanguage');
            // Item definition with false `languageCode` will behave as remove lang button.
            itemDefinitions.add({
                type: 'button',
                model: new UI.ViewModel({
                    label: removeTitle,
                    languageCode: false,
                    withText: true
                })
            });
            itemDefinitions.add({
                type: 'separator'
            });
            for (const option of options) {
                const def = {
                    type: 'button',
                    model: new UI.ViewModel({
                        label: option.title,
                        languageCode: option.languageCode,
                        role: 'menuitemradio',
                        textDirection: option.textDirection,
                        withText: true
                    })
                };
                const language = stringifyLanguageAttribute(option.languageCode, option.textDirection);
                def.model.bind('isOn').to(languageCommand, 'value', value => value === language);
                itemDefinitions.add(def);
                titles[language] = option.title;
            }
            const dropdownView = UI.createDropdown(locale);
            UI.addListToDropdown(dropdownView, itemDefinitions, {
                ariaLabel: accessibleLabel,
                role: 'menu'
            });
            dropdownView.buttonView.set({
                ariaLabel: accessibleLabel,
                ariaLabelledBy: undefined,
                isOn: false,
                tooltip: accessibleLabel,
                icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 23h-2.784l-1.07-3h-4.875l-1.077 3h-2.697l4.941-13h2.604l4.958 13zm-4.573-5.069l-1.705-4.903-1.712 4.903h3.417zm-9.252-10.804c.126-.486.201-.852.271-1.212l-2.199-.428c-.036.185-.102.533-.22 1-.742-.109-1.532-.122-2.332-.041.019-.537.052-1.063.098-1.569h2.456v-2.083h-2.161c.106-.531.198-.849.288-1.149l-2.147-.645c-.158.526-.29 1.042-.422 1.794h-2.451v2.083h2.184c-.058.673-.093 1.371-.103 2.077-2.413.886-3.437 2.575-3.437 4.107 0 1.809 1.427 3.399 3.684 3.194 2.802-.255 4.673-2.371 5.77-4.974 1.134.654 1.608 1.753 1.181 2.771-.396.941-1.561 1.838-3.785 1.792v2.242c2.469.038 4.898-.899 5.85-3.166.93-2.214-.132-4.635-2.525-5.793zm-2.892 1.531c-.349.774-.809 1.543-1.395 2.149-.09-.645-.151-1.352-.184-2.107.533-.07 1.072-.083 1.579-.042zm-3.788.724c.062.947.169 1.818.317 2.596-1.996.365-2.076-1.603-.317-2.596z"/></svg>'
            });
            dropdownView.extendTemplate({
                attributes: {
                    class: [
                        'ck-text-fragment-language-dropdown'
                    ]
                }
            });
            dropdownView.bind('isEnabled').to(languageCommand, 'isEnabled');

            // Execute command when an item from the dropdown is selected.
            this.listenTo(dropdownView, 'execute', evt => {
                languageCommand.execute({
                    languageCode: evt.source.languageCode,
                    textDirection: evt.source.textDirection
                });
                editor.editing.view.focus();
            });
            return dropdownView;
        });
    }
}
