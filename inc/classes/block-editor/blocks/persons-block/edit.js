import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import CountControl from './components/CountControl';
import CareerControl from './components/CareerControl';
import { Spinner } from '@wordpress/components';
import PersonsList from './components/PersonsList';

/**
 * WordPress Edit component for a person-related block.
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
	 * Sets the career attribute of the block.
	 *
	 * @param {number} val
	 */
	const setCareer = (val) => setAttributes({ career: val ?? 0 });

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

	const { count, career } = attributes;

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

			// Set person career taxonomy query.
			if (
				career &&
				typeof career === 'number' &&
				Number.isInteger(career) &&
				career > 0
			) {
				query['mlib-person-career'] = career;
			}

			const selectorArgs = ['postType', 'mlib-person', query];

			return {
				queriedPosts: select(coreDataStore).getEntityRecords(
					...selectorArgs
				),
				haveQueriedPostsResolved: select(
					coreDataStore
				).hasFinishedResolution('getEntityRecords', selectorArgs),
			};
		},
		[count, career]
	);

	return (
		<div {...useBlockProps()}>
			<InspectorControls key="persons-block-controls">
				<div className="persons-block-controls">
					<CountControl count={count} setCount={setCount} />
					<CareerControl setCareer={setCareer} career={career} />
				</div>
			</InspectorControls>
			{haveQueriedPostsResolved ? (
				<PersonsList queriedPosts={queriedPosts} career={career} />
			) : (
				<Spinner />
			)}
		</div>
	);
}
