import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { Spinner } from '@wordpress/components';
import { decodeEntities } from '@wordpress/html-entities';
import { __ } from '@wordpress/i18n';
import PersonSelectorControl from './components/PersonSelectorControl';
import SinglePerson from './components/SinglePerson';

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
	 * Sets the person attribute of the block.
	 *
	 * @param {number} val
	 */
	const setPerson = (val) =>
		setAttributes({ person: val ?? attributes.person });

	const { person } = attributes;

	// Query the posts each time the user selects a filter.
	const { queriedPost, hasPostResolved } = useSelect(
		(select) => {
			// Set base query params
			const query = { _embed: true };

			if (
				!person ||
				typeof person !== 'number' ||
				!Number.isInteger(person) ||
				person <= 0
			) {
				return {
					queriedPost: {},
					hasPostResolved: true,
				};
			}

			const selectorArgs = ['postType', 'mlib-person', person, query];

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
		[person]
	);

	return (
		<div {...useBlockProps()}>
			<InspectorControls key="person-block-controls">
				<div className="person-block-controls">
					<PersonSelectorControl
						person={person}
						setPerson={setPerson}
					/>
				</div>
			</InspectorControls>
			{hasPostResolved && queriedPost.title && queriedPost._embedded ? (
				<SinglePerson
					title={decodeEntities(
						queriedPost.title
							? queriedPost.title.rendered
							: __('No person selected', 'movie-library')
					)}
					thumbnail={
						queriedPost._embedded &&
						queriedPost._embedded['wp:featuredmedia']
							? queriedPost._embedded['wp:featuredmedia'][0]
									.source_url
							: ''
					}
					careers={queriedPost['mlib-person-career']}
				/>
			) : (
				<Spinner />
			)}
		</div>
	);
}
