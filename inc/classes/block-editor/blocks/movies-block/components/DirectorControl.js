import { ComboboxControl, Spinner } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for controlling the selection of a movie director.
 *
 * This component renders a ComboboxControl to select a movie director based on
 * available options retrieved from the WordPress database.
 *
 * @param {Object}   props                - The properties passed to the DirectorControl component.
 * @param {Function} props.setDirector    - A function to set the selected movie director.
 * @param {number}   props.directorTermID - The ID of the director term in the database.
 * @param {number}   props.director       - The currently selected director.
 * @return {JSX.Element} JSX element representing the director control.
 */
export default function DirectorControl({
	setDirector,
	directorTermID,
	director,
}) {
	const [options, setOptions] = useState([]);
	const [filteredOptions, setFilteredOptions] = useState([]);
	const { directors, haveDirectorsResolved } = useSelect((select) => {
		const query = {
			'mlib-person-career': directorTermID,
		};
		const selectorArgs = ['postType', 'mlib-person', query];

		return {
			directors: select(coreDataStore).getEntityRecords(...selectorArgs),
			haveDirectorsResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecords',
				selectorArgs
			),
		};
	}, []);

	// Set up directors list if resolved.
	useEffect(() => {
		if (!haveDirectorsResolved || !directors) {
			return;
		}
		const directorOptions = directors.map((currDirector) => ({
			label: decodeEntities(currDirector.title.rendered),
			value: currDirector.id,
		}));
		setOptions([...directorOptions]);
		setFilteredOptions([...directorOptions]);
	}, [haveDirectorsResolved]);

	return (
		<fieldset>
			<legend>{__('Select Director', 'movie-library')}</legend>
			{haveDirectorsResolved && directors ? (
				<ComboboxControl
					label={__('Director', 'movie-library')}
					value={director}
					onChange={setDirector}
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
