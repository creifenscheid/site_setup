export default class L10n {

    static fallbackLanguage = 'en';

    static translations = {
        'en': {
            'dropdownLabel': 'Set language for selection',
            'langRemove': 'Remove language'
        },
        'de': {
            'dropdownLabel': 'Sprache für die Auswahl einstellen',
            'langRemove': 'Sprache entfernen'
        }
    };

    constructor (language) {
        this._uiLanguage = language.ui;

        if (L10n.translations[this._uiLanguage] === undefined) {
            this._uiLanguage = L10n.fallbackLanguage;
        }
    }

    locale( key, fallback = 'No translation found')
    {
        const languageTranslations = L10n.translations[this._uiLanguage];

        if (languageTranslations[key] === undefined) {
            return fallback;
        }

        return languageTranslations[key];
    }
}