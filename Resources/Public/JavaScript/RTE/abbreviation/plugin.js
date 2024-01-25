import AbbreviationUI from "./components/ui.js";
import AbbreviationEditing from "./components/edit.js";
import {Core} from "@typo3/ckeditor5-bundle.js";

export default class Abbreviation extends Core.Plugin {
	static pluginName = 'Abbreviation';

	static get requires() {
		return [ AbbreviationEditing, AbbreviationUI ];
	}
}