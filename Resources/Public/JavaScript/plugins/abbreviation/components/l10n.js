export default class L10n {

    static fallbackLanguage = 'en';

    static translations = {
        'en': {
            'labelAbbr': 'Add abbreviation',
            'labelTitle': 'Add title'
        },
        'de': {
            'labelAbbr': 'Abkürzung hinzufügen',
            'labelTitle': 'Titel hinzufügen'
        }
    };

    constructor (locale) {
        this._uiLanguage = locale.uiLanguage;

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