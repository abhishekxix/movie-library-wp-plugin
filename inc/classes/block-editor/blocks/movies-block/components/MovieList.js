import { useEffect, useState } from '@wordpress/element';
import { store as coreDataStore } from '@wordpress/core-data';
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for displaying a list of movies.
 *
 * This component renders a list of movies based on queried posts and filters
 * them by director if specified.
 *
 * @param {Object} props              - The properties passed to the MoviesList component.
 * @param {Array}  props.queriedPosts - An array of queried movie posts.
 * @param {number} props.director     - The director ID for filtering movies.
 * @return {JSX.Element} JSX element representing the movies list.
 */
export default function MoviesList({ queriedPosts, director }) {
	const [posts, setPosts] = useState(queriedPosts);

	// Filter the movies by director.
	useEffect(() => {
		if (director !== 0) {
			setPosts(
				queriedPosts.filter((item) => {
					let postDirectors = [];

					try {
						postDirectors = JSON.parse(
							item.meta['mlib-movie-meta-crew-director']
						);
					} catch (error) {}

					return (
						Array.isArray(postDirectors) &&
						postDirectors.includes(director)
					);
				})
			);
		} else {
			setPosts(queriedPosts);
		}
	}, [queriedPosts, director]);

	return posts.length > 0 ? (
		<ul className="movie-library-movies-list">
			{posts.map((item) => (
				<li key={item.id}>
					<MovieListItem
						title={decodeEntities(item.title.rendered)}
						thumbnail={
							item._embedded['wp:featuredmedia']
								? item._embedded['wp:featuredmedia'][0]
										.source_url
								: ''
						}
						releaseDate={
							item.meta['mlib-movie-meta-basic-release-date']
						}
						director={director}
						actors={item.meta['mlib-movie-meta-crew-actor']}
					/>
				</li>
			))}
		</ul>
	) : (
		<p>{__('No movies found', 'movie-library')}</p>
	);
}

/**
 * Component for displaying a single movie item.
 *
 * This component displays details of a single movie item, including its title,
 * thumbnail, release date, director, and actors.
 *
 * @param {Object} props             - The properties passed to the MovieListItem component.
 * @param {string} props.title       - The title of the movie.
 * @param {string} props.thumbnail   - The URL of the movie's thumbnail image.
 * @param {string} props.releaseDate - The release date of the movie.
 * @param {number} props.director    - The director ID of the movie.
 * @param {Array}  props.actors      - An array of actor IDs in the movie.
 * @return {JSX.Element} JSX element representing a movie item.
 */
function MovieListItem({ title, thumbnail, releaseDate, director, actors }) {
	const [directorName, setDirectorName] = useState('');
	const [actorNames, setActorNames] = useState([]);

	// Select the information about the selected director.
	const { directorRecord, hasDirectorResolved } = useSelect((select) => {
		const selectorArgs = ['postType', 'mlib-person', director];
		if (director === 0) {
			return {
				directorRecord: { title: { rendered: '' } },
				hasDirectorResolved: true,
			};
		}
		return {
			directorRecord: select(coreDataStore).getEntityRecord(
				...selectorArgs
			),
			hasDirectorResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecord',
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

	// Set director name if resolved.
	useEffect(() => {
		if (!hasDirectorResolved) {
			return;
		}

		setDirectorName(decodeEntities(directorRecord.title.rendered));
	}, [hasDirectorResolved]);

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
		<>
			<img src={thumbnail} alt={title} />
			<p>{`${__('Title', 'movie-library')}: ${title}`}</p>
			<p>{`${__('Release Date', 'movie-library')}: ${releaseDate}`}</p>
			<p>{`${__('Director', 'movie-library')}: ${directorName}`}</p>
			<p>{`${__('Actors', 'movie-library')}: ${actorNames.join(
				', '
			)}`}</p>
		</>
	);
}
