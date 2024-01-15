import { ComboboxControl, Spinner } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for controlling the selection of a movie language.
 *
 * This component renders a ComboboxControl to select a movie language based on
 * available options retrieved from the WordPress database.
 *
 * @param {Object}   props             - The properties passed to the LanguageControl component.
 * @param {Function} props.setLanguage - A function to set the selected movie language.
 * @param {number}   props.language    - The currently selected movie language.
 * @return {JSX.Element} JSX element representing the language control.
 */
export default function LanguageControl({ setLanguage, language }) {
	const [options, setOptions] = useState([]);
	const [filteredOptions, setFilteredOptions] = useState([]);

	const { languages, haveLanguagesResolved } = useSelect((select) => {
		const query = {
			per_page: -1,
		};
		const selectorArgs = ['taxonomy', 'mlib-movie-language', query];

		return {
			languages: select(coreDataStore).getEntityRecords(...selectorArgs),
			haveLanguagesResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecords',
				selectorArgs
			),
		};
	}, []);

	// Set up the languages when resolved.
	useEffect(() => {
		if (!haveLanguagesResolved || !languages) {
			return;
		}
		const languageOptions = languages.map((currLanguage) => ({
			label: decodeEntities(currLanguage.name),
			value: currLanguage.id,
		}));
		setOptions([...languageOptions]);
		setFilteredOptions([...languageOptions]);
	}, [haveLanguagesResolved]);

	return (
		<fieldset>
			<legend>{__('Select Language', 'movie-library')}</legend>
			{haveLanguagesResolved && languages ? (
				<ComboboxControl
					label={__('Language', 'movie-library')}
					value={language}
					onChange={setLanguage}
					options={filteredOptions}
					onFilterValueChange={(inputValue) =>
						setFilteredOptions(
							options.filter((option) =>
								option.label
									.toLowerCase()
									.startsWith(inputValue.toLowerCase())
							)
						)
					}
				/>
			) : (
				<Spinner />
			)}
		</fieldset>
	);
}
