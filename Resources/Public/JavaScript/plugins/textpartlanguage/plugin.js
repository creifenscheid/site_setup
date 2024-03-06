import TextPartLanguageUI from "./components/ui.js";
import TextPartLanguageEditing from "./components/edit.js";
import {Core} from "@typo3/ckeditor5-bundle.js";


export default class TextPartLanguage extends Core.Plugin {

    static get requires() {
        return [TextPartLanguageEditing, TextPartLanguageUI];
    }

    static get pluginName() {
        return 'TextPartLanguage';
    }
}
