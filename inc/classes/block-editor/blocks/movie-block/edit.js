import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { Spinner } from '@wordpress/components';
import { decodeEntities } from '@wordpress/html-entities';
import MovieSelectorControl from './components/MovieSelectorControl';
import SingleMovie from './components/SingleMovie';

/**
 * WordPress Edit component for a movie-related block.
 *
 * This component is responsible for rendering the block in the block editor and
 * handling user interactions in the editing mode.
 *
 * @param {Object}   props               - The properties passed to the Edit component.
 * @param {Object}   props.attributes    - The block attributes.
 * @param {Function} props.setAttributes - A function to set block attributes.
 *
 * @return {JSX.Element} JSX element representing the block in the editor.
 */
export function Edit({ attributes, setAttributes }) {
	/**
	 * Sets the movie attribute of the block.
	 *
	 * @param {number} val
	 */
	const setMovie = (val) => setAttributes({ movie: val ?? attributes.movie });

	const { movie } = attributes;

	// Query the posts each time the user selects a filter.
	const { queriedPost, hasPostResolved } = useSelect(
		(select) => {
			// Set base query params
			const query = { _embed: true };

			// Set language taxonomy query
			if (
				!movie ||
				typeof movie !== 'number' ||
				!Number.isInteger(movie) ||
				movie <= 0
			) {
				return {
					queriedPost: {},
					hasPostResolved: true,
				};
			}

			const selectorArgs = ['postType', 'mlib-movie', movie, query];

			return {
				queriedPost: select(coreDataStore).getEntityRecord(
					...selectorArgs
				),
				hasPostResolved: select(coreDataStore).hasFinishedResolution(
					'getEntityRecord',
					selectorArgs
				),
			};
		},
		[movie]
	);

	return (
		<div {...useBlockProps()}>
			<InspectorControls key="movies-block-controls">
				<div className="movie-block-controls">
					<MovieSelectorControl movie={movie} setMovie={setMovie} />
				</div>
			</InspectorControls>
			{hasPostResolved &&
			queriedPost.title &&
			queriedPost._embedded &&
			queriedPost.meta ? (
				<SingleMovie
					title={decodeEntities(
						queriedPost.title
							? queriedPost.title.rendered
							: 'No movie selected'
					)}
					thumbnail={
						queriedPost._embedded &&
						queriedPost._embedded['wp:featuredmedia']
							? queriedPost._embedded['wp:featuredmedia'][0]
									.source_url
							: ''
					}
					releaseDate={
						queriedPost.meta['mlib-movie-meta-basic-release-date']
					}
					directors={queriedPost.meta['mlib-movie-meta-crew-director']}
					actors={queriedPost.meta['mlib-movie-meta-crew-actor']}
				/>
			) : (
				<Spinner />
			)}
		</div>
	);
}
