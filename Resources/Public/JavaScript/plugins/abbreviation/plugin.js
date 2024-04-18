import AbbreviationUI from "./components/ui.js";
import AbbreviationEditing from "./components/edit.js";
import * as Core from"@ckeditor/ckeditor5-core"

export default class Abbreviation extends Core.Plugin {
	static pluginName = 'Abbreviation';

	static get requires() {
		return [ AbbreviationEditing, AbbreviationUI ];
	}
}
