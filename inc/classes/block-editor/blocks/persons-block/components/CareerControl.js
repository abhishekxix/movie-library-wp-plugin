import { ComboboxControl, Spinner } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for controlling the selection of a person career.
 *
 * This component renders a ComboboxControl to select a person career based on
 * available options retrieved from the WordPress database.
 *
 * @param {Object}   props           - The properties passed to the CareerControl component.
 * @param {Function} props.setCareer - A function to set the selected person career.
 * @param {number}   props.career    - The currently selected person career.
 * @return {JSX.Element} JSX element representing the career control.
 */
export default function CareerControl({ setCareer, career }) {
	const [options, setOptions] = useState([]);
	const [filteredOptions, setFilteredOptions] = useState([]);

	const { careers, haveCareersResolved } = useSelect((select) => {
		const query = {
			per_page: -1,
		};
		const selectorArgs = ['taxonomy', 'mlib-person-career', query];

		return {
			careers: select(coreDataStore).getEntityRecords(...selectorArgs),
			haveCareersResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecords',
				selectorArgs
			),
		};
	}, []);

	// Set up career options if resolved.
	useEffect(() => {
		if (!haveCareersResolved || !careers) {
			return;
		}
		const careerOptions = careers.map((currCareer) => ({
			label: decodeEntities(currCareer.name),
			value: currCareer.id,
		}));
		setOptions([...careerOptions]);
		setFilteredOptions([...careerOptions]);
	}, [haveCareersResolved]);

	return (
		<fieldset>
			<legend>{__('Select Career', 'movie-library')}</legend>
			{haveCareersResolved && careers ? (
				<ComboboxControl
					label={__('Career', 'movie-library')}
					value={career}
					onChange={setCareer}
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
