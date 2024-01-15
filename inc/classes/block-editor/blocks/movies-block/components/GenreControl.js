import { ComboboxControl, Spinner } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for controlling the selection of a movie genre.
 *
 * This component renders a ComboboxControl to select a movie genre based on
 * available options retrieved from the WordPress database.
 *
 * @param {Object}   props          - The properties passed to the GenreControl component.
 * @param {Function} props.setGenre - A function to set the selected movie genre.
 * @param {number}   props.genre    - The currently selected movie genre.
 * @return {JSX.Element} JSX element representing the genre control.
 */
export default function GenreControl({ setGenre, genre }) {
	const [options, setOptions] = useState([]);
	const [filteredOptions, setFilteredOptions] = useState([]);

	const { genres, haveGenresResolved } = useSelect((select) => {
		const query = {
			per_page: -1,
		};
		const selectorArgs = ['taxonomy', 'mlib-movie-genre', query];

		return {
			genres: select(coreDataStore).getEntityRecords(...selectorArgs),
			haveGenresResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecords',
				selectorArgs
			),
		};
	}, []);

	// Set up genre options if resolved.
	useEffect(() => {
		if (!haveGenresResolved || !genres) {
			return;
		}
		const genreOptions = genres.map((currGenre) => ({
			label: decodeEntities(currGenre.name),
			value: currGenre.id,
		}));
		setOptions([...genreOptions]);
		setFilteredOptions([...genreOptions]);
	}, [haveGenresResolved]);

	return (
		<fieldset>
			<legend>{__('Select Genre', 'movie-library')}</legend>
			{haveGenresResolved && genres ? (
				<ComboboxControl
					label={__('Genre', 'movie-library')}
					value={genre}
					onChange={setGenre}
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
