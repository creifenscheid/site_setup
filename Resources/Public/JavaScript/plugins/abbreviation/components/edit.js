﻿import * as Core from"@ckeditor/ckeditor5-core";

export default class AbbreviationEditing extends Core.Plugin {
    init () {
        this._defineSchema();
        this._defineConverters();
    }

    _defineSchema () {
        const schema = this.editor.model.schema;

        // Extend the text node's schema to accept the abbreviation attribute.
        schema.extend('$text', {
            allowAttributes: ['abbreviation']
        });
    }

    _defineConverters () {
        const conversion = this.editor.conversion;

        // Conversion from a model attribute to a view element.
        conversion.for('downcast').attributeToElement({
            model: 'abbreviation',
            // Callback function provides access to the model attribute value and the DowncastWriter.
            view: (modelAttributeValue, conversionApi) => {
                const {writer} = conversionApi;

                return writer.createAttributeElement('abbr', {
                    title: modelAttributeValue
                });
            }
        });

        conversion.for( 'upcast' ).elementToAttribute( {
            view: {
                name: 'abbr',
                attributes: [ 'title' ]
            },
            model: {
                key: 'abbreviation',
                // Callback function provides access to the view element.
                value: viewElement => {
                    return viewElement.getAttribute( 'title' );
                }
            }
        } );
    }
}
