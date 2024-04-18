import TextPartLanguageUI from "./components/ui.js";
import TextPartLanguageEditing from "./components/edit.js";
import * as Core from"@ckeditor/ckeditor5-core";


export default class TextPartLanguage extends Core.Plugin {

    static get requires() {
        return [TextPartLanguageEditing, TextPartLanguageUI];
    }

    static get pluginName() {
        return 'TextPartLanguage';
    }
}
