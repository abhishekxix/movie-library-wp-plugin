import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { Spinner, ComboboxControl } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for controlling the selection of a movie.
 *
 * This component renders a ComboboxControl to select a movie based on available
 * options retrieved from the WordPress database.
 *
 * @param {Object}   props          - The properties passed to the MovieSelectorControl component.
 * @param {number}   props.movie    - The ID of the selected movie.
 * @param {Function} props.setMovie - A function to set the selected movie.
 * @return {JSX.Element} JSX element representing the movie selector control.
 */
export default function MovieSelectorControl({ movie, setMovie }) {
	const [options, setOptions] = useState([]);
	const [filteredOptions, setFilteredOptions] = useState([]);

	const { movies, haveMoviesResolved } = useSelect((select) => {
		const query = {
			per_page: 100,
			_embed: true,
		};
		const selectorArgs = ['postType', 'mlib-movie', query];

		return {
			movies: select(coreDataStore).getEntityRecords(...selectorArgs),
			haveMoviesResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecords',
				selectorArgs
			),
		};
	}, []);

	// Set up Movie options if resolved.
	useEffect(() => {
		if (!haveMoviesResolved || !movies) {
			return;
		}
		const movieOptions = movies.map((currMovie) => ({
			label: decodeEntities(currMovie.title.rendered),
			value: currMovie.id,
		}));
		setOptions([...movieOptions]);
		setFilteredOptions([...movieOptions]);
	}, [haveMoviesResolved]);

	return (
		<fieldset>
			<legend>{__('Select Movie', 'movie-library')}</legend>
			{haveMoviesResolved && movies ? (
				<ComboboxControl
					label={__('Movie', 'movie-library')}
					value={movie}
					onChange={setMovie}
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
