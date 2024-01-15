import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { Spinner, ComboboxControl } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for controlling the selection of a Person.
 *
 * This component renders a ComboboxControl to select a person based on available
 * options retrieved from the WordPress database.
 *
 * @param {Object}   props           - The properties passed to the PersonSelectorControl component.
 * @param {number}   props.person    - The ID of the selected person.
 * @param {Function} props.setPerson - A function to set the selected person.
 * @return {JSX.Element} JSX element representing the person selector control.
 */
export default function PersonSelectorControl({ person, setPerson }) {
	const [options, setOptions] = useState([]);
	const [filteredOptions, setFilteredOptions] = useState([]);

	const { persons, havePersonsResolved } = useSelect((select) => {
		const query = {
			per_page: 100,
			_embed: true,
		};
		const selectorArgs = ['postType', 'mlib-person', query];

		return {
			persons: select(coreDataStore).getEntityRecords(...selectorArgs),
			havePersonsResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecords',
				selectorArgs
			),
		};
	}, []);

	// Set up person options if resolved.
	useEffect(() => {
		if (!havePersonsResolved || !persons) {
			return;
		}
		const personOptions = persons.map((currPerson) => ({
			label: decodeEntities(currPerson.title.rendered),
			value: currPerson.id,
		}));
		setOptions([...personOptions]);
		setFilteredOptions([...personOptions]);
	}, [havePersonsResolved]);

	return (
		<fieldset>
			<legend>{__('Select Person', 'movie-library')}</legend>
			{havePersonsResolved && persons ? (
				<ComboboxControl
					label={__('Person', 'movie-library')}
					value={person}
					onChange={setPerson}
					options={filteredOptions}
					onFilterValueChange={(inputValue) =>
						setFilteredOptions(
							options.filter((option) =>
								option.label
									.toLowerCase()
									.includes(inputValue.toLowerCase())
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
