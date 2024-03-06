import TextPartLanguageCommand from './command.js';
import { stringifyLanguageAttribute, parseLanguageAttribute } from './utils.js';
import * as Core from"@ckeditor/ckeditor5-core";

export default class TextPartLanguageEditing extends Core.Plugin {

    static get pluginName() {
        return 'TextPartLanguageEditing';
    }

    constructor(editor) {
        super(editor);
        // Text part language options are only used to ensure that the feature works by default.
        // In the real usage it should be reconfigured by a developer. We are not providing
        // translations for `title` properties on purpose, as it's only an example configuration.
        editor.config.define('language', {
            textPartLanguage: [
                { title: 'Arabic', languageCode: 'ar' },
                { title: 'French', languageCode: 'fr' },
                { title: 'Spanish', languageCode: 'es' }
            ]
        });
    }

    init() {
        const editor = this.editor;
        editor.model.schema.extend('$text', { allowAttributes: 'language' });
        editor.model.schema.setAttributeProperties('language', {
            copyOnEnter: true
        });
        this._defineConverters();
        editor.commands.add('textPartLanguage', new TextPartLanguageCommand(editor));
    }

    _defineConverters() {
        const conversion = this.editor.conversion;
        conversion.for('upcast').elementToAttribute({
            model: {
                key: 'language',
                value: (viewElement) => {
                    const languageCode = viewElement.getAttribute('lang');
                    const textDirection = viewElement.getAttribute('dir');
                    return stringifyLanguageAttribute(languageCode, textDirection);
                }
            },
            view: {
                name: 'span',
                attributes: { lang: /[\s\S]+/ }
            }
        });
        conversion.for('downcast').attributeToElement({
            model: 'language',
            view: (attributeValue, { writer }, data) => {
                if (!attributeValue) {
                    return;
                }
                if (!data.item.is('$textProxy') && !data.item.is('documentSelection')) {
                    return;
                }
                const { languageCode, textDirection } = parseLanguageAttribute(attributeValue);
                return writer.createAttributeElement('span', {
                    lang: languageCode,
                    dir: textDirection
                });
            }
        });
    }
}
