import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for displaying a single movie item.
 *
 * This component displays details of a single movie item, including its title,
 * thumbnail, release date, director, and actors.
 *
 * @param {Object} props             - The properties passed to the SingleMovie component.
 * @param {string} props.title       - The title of the movie.
 * @param {string} props.thumbnail   - The URL of the movie's thumbnail image.
 * @param {string} props.releaseDate - The release date of the movie.
 * @param {Array}  props.directors   - An array of director IDs in the movie.
 * @param {Array}  props.actors      - An array of actor IDs in the movie.
 * @return {JSX.Element} JSX element representing a movie item.
 */
export default function SingleMovie({
	title,
	thumbnail,
	releaseDate,
	directors,
	actors,
}) {
	const [directorNames, setDirectorNames] = useState([]);
	const [actorNames, setActorNames] = useState([]);

	// Select the information about the actors for the movie.
	const { directorRecords, haveDirectorsResolved } = useSelect((select) => {
		let directorIDs = [];

		try {
			directorIDs = JSON.parse(directors);
		} catch (error) {}

		if (!Array.isArray(directorIDs)) {
			return {
				directorRecords: [],
				haveDirectorsResolved: true,
			};
		}

		const include = directorIDs.slice(0, 2);

		const selectorArgs = ['postType', 'mlib-person', { include }];
		return {
			directorRecords: select(coreDataStore).getEntityRecords(
				...selectorArgs
			),
			haveDirectorsResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecords',
				selectorArgs
			),
		};
	});

	// Select the information about the actors for the movie.
	const { actorRecords, haveActorsResolved } = useSelect((select) => {
		let actorIDs = [];

		try {
			actorIDs = JSON.parse(actors);
		} catch (error) {}

		if (!Array.isArray(actorIDs)) {
			return {
				actorRecords: [],
				haveActorsResolved: true,
			};
		}

		const include = actorIDs.slice(0, 2);

		const selectorArgs = ['postType', 'mlib-person', { include }];
		return {
			actorRecords: select(coreDataStore).getEntityRecords(
				...selectorArgs
			),
			haveActorsResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecords',
				selectorArgs
			),
		};
	});

	// Set Director names if resolved.
	useEffect(() => {
		if (!haveDirectorsResolved) {
			return;
		}
		setDirectorNames(
			directorRecords.map((director) =>
				decodeEntities(director.title.rendered)
			)
		);
	}, [haveDirectorsResolved]);

	// Set actor names if resolved.
	useEffect(() => {
		if (!haveActorsResolved) {
			return;
		}
		setActorNames(
			actorRecords.map((actor) => decodeEntities(actor.title.rendered))
		);
	}, [haveActorsResolved]);

	return (
		<div className="movie-library-single-movie">
			<img src={thumbnail} alt={title} />
			<p>{`${__('Title', 'movie-library')}: ${title}`}</p>
			<p>{`${__('Release Date', 'movie-library')}: ${releaseDate}`}</p>
			<p>{`${__('Director', 'movie-library')}: ${directorNames.join(
				', '
			)}`}</p>
			<p>{`${__('Actors', 'movie-library')}: ${actorNames.join(
				', '
			)}`}</p>
		</div>
	);
}
