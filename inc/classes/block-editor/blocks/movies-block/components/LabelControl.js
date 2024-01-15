import { ComboboxControl, Spinner } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for controlling the selection of a movie label.
 *
 * This component renders a ComboboxControl to select a movie label based on
 * available options retrieved from the WordPress database.
 *
 * @param {Object}   props          - The properties passed to the LabelControl component.
 * @param {Function} props.setLabel - A function to set the selected movie label.
 * @param {number}   props.label    - The currently selected movie label.
 * @return {JSX.Element} JSX element representing the label control.
 */

export default function LabelControl({ setLabel, label }) {
	const [options, setOptions] = useState([]);
	const [filteredOptions, setFilteredOptions] = useState([]);

	const { labels, haveLabelsResolved } = useSelect((select) => {
		const query = {
			per_page: -1,
		};
		const selectorArgs = ['taxonomy', 'mlib-movie-label', query];

		return {
			labels: select(coreDataStore).getEntityRecords(...selectorArgs),
			haveLabelsResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecords',
				selectorArgs
			),
		};
	}, []);

	// Set up the options if query resolved.
	useEffect(() => {
		if (!haveLabelsResolved || !labels) {
			return;
		}
		const labelOptions = labels.map((currLabel) => ({
			label: decodeEntities(currLabel.name),
			value: currLabel.id,
		}));
		setOptions([...labelOptions]);
		setFilteredOptions([...labelOptions]);
	}, [haveLabelsResolved]);

	return (
		<fieldset>
			<legend>{__('Select Label', 'movie-library')}</legend>
			{haveLabelsResolved && labels ? (
				<ComboboxControl
					label={__('Label', 'movie-library')}
					value={label}
					onChange={setLabel}
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
