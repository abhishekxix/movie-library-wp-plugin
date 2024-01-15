import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import CountControl from './components/CountControl';
import DirectorControl from './components/DirectorControl';
import GenreControl from './components/GenreControl';
import LabelControl from './components/LabelControl';
import LanguageControl from './components/LanguageControl';
import { Spinner } from '@wordpress/components';
import MoviesList from './components/MovieList';

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
	 * Sets the director attribute of the block.
	 *
	 * @param {number} val
	 */
	const setDirector = (val) => setAttributes({ director: val ?? 0 });

	/**
	 * Sets the genre attribute of the block.
	 *
	 * @param {number} val
	 */
	const setGenre = (val) => setAttributes({ genre: val ?? 0 });

	/**
	 * Sets the label attribute of the block.
	 *
	 * @param {number} val
	 */
	const setLabel = (val) => setAttributes({ label: val ?? 0 });

	/**
	 * Sets the language attribute of the block.
	 *
	 * @param {number} val
	 */
	const setLanguage = (val) => setAttributes({ language: val ?? 0 });

	/**
	 * Sets the count attribute of the block.
	 *
	 * Converts count into an integer if possible.
	 *
	 * @param {number|string} val
	 */
	const setCount = (val) => {
		if (!val || (typeof val !== 'number' && typeof val !== 'string')) {
			return;
		}

		const intCount = Number.parseInt(val);

		if (Number.isInteger(intCount) && intCount > 0 && intCount <= 10) {
			setAttributes({ count: intCount });
		}
	};

	const { director, genre, label, language, count } = attributes;

	// Select the term id for 'director'.
	const { directorTerm, hasDirectorTermResolved } = useSelect((select) => {
		const query = { slug: 'director' };
		const selectorArgs = ['taxonomy', 'mlib-person-career', query];

		return {
			directorTerm: select(coreDataStore).getEntityRecords(
				...selectorArgs
			),
			hasDirectorTermResolved: select(
				coreDataStore
			).hasFinishedResolution('getEntityRecords', selectorArgs),
		};
	}, []);

	// Query the posts each time the user selects a filter.
	const { queriedPosts, haveQueriedPostsResolved } = useSelect(
		(select) => {
			// Set base query params
			const query = { per_page: 5, _embed: true };

			// Set posts per page.
			if (
				count &&
				(typeof count === 'number' || typeof count === 'string')
			) {
				const intCount = Number.parseInt(count);

				if (
					Number.isInteger(intCount) &&
					intCount > 0 &&
					intCount <= 10
				) {
					query.per_page = intCount;
				}
			}

			// Set movie genre taxonomy query.
			if (
				genre &&
				typeof genre === 'number' &&
				Number.isInteger(genre) &&
				genre > 0
			) {
				query['mlib-movie-genre'] = genre;
			}

			// Set movie label taxonomy query.
			if (
				label &&
				typeof label === 'number' &&
				Number.isInteger(label) &&
				label > 0
			) {
				query['mlib-movie-label'] = label;
			}

			// Set language taxonomy query
			if (
				language &&
				typeof language === 'number' &&
				Number.isInteger(language) &&
				language > 0
			) {
				query['mlib-movie-language'] = language;
			}

			const selectorArgs = ['postType', 'mlib-movie', query];

			return {
				queriedPosts: select(coreDataStore).getEntityRecords(
					...selectorArgs
				),
				haveQueriedPostsResolved: select(
					coreDataStore
				).hasFinishedResolution('getEntityRecords', selectorArgs),
			};
		},
		[genre, label, language, count]
	);

	return (
		<div {...useBlockProps()}>
			<InspectorControls key="movies-block-controls">
				<div id="movies-block-controls">
					<CountControl count={count} setCount={setCount} />
					{hasDirectorTermResolved && directorTerm && (
						<DirectorControl
							directorTermID={directorTerm[0].id}
							setDirector={setDirector}
							director={director}
						/>
					)}
					<GenreControl setGenre={setGenre} genre={genre} />
					<LabelControl setLabel={setLabel} label={label} />
					<LanguageControl
						setLanguage={setLanguage}
						language={language}
					/>
				</div>
			</InspectorControls>
			{haveQueriedPostsResolved ? (
				<MoviesList queriedPosts={queriedPosts} director={director} />
			) : (
				<Spinner />
			)}
		</div>
	);
}
