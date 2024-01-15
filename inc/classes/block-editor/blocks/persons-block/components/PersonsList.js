import { store as coreDataStore } from '@wordpress/core-data';
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for displaying a list of persons.
 *
 * This component renders a list of persons based on queried posts.
 *
 * @param {Object} props              - The properties passed to the MoviesList component.
 * @param {Array}  props.queriedPosts - An array of queried movie posts.
 * @param {number} props.career       - The career ID.
 * @return {JSX.Element} JSX element representing the persons list.
 */
export default function PersonsList({ queriedPosts, career }) {
	const { careerTerm, hasCareerTermResolved } = useSelect((select) => {
		const selectorArgs = ['taxonomy', 'mlib-person-career', career];

		if (career === 0) {
			return {
				careerTerm: { name: '' },
				hasCareerTermResolved: true,
			};
		}

		return {
			careerTerm: select(coreDataStore).getEntityRecord(...selectorArgs),
			hasCareerTermResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecord',
				selectorArgs
			),
		};
	});

	return queriedPosts.length > 0 && hasCareerTermResolved ? (
		<ul className="movie-library-persons-list">
			{queriedPosts.map((item) => (
				<li key={item.id}>
					<PersonListItem
						title={decodeEntities(item.title.rendered)}
						thumbnail={
							item._embedded['wp:featuredmedia']
								? item._embedded['wp:featuredmedia'][0]
										.source_url
								: ''
						}
						careerName={careerTerm.name}
					/>
				</li>
			))}
		</ul>
	) : (
		<p>{__('No persons found', 'movie-library')}</p>
	);
}

/**
 * Component for displaying a single person item.
 *
 * This component displays details of a single person item, including its title,
 * thumbnail, career.
 *
 * @param {Object} props            - The properties passed to the PersonListItem component.
 * @param {string} props.title      - The title of the movie.
 * @param {string} props.thumbnail  - The URL of the movie's thumbnail image.
 * @param {string} props.careerName - The  career name of the Person.
 * @return {JSX.Element} JSX element representing a movie item.
 */
function PersonListItem({ title, thumbnail, careerName }) {
	return (
		<>
			<img src={thumbnail} alt={title} />
			<p>{`${__('Name', 'movie-library')}: ${title}`}</p>
			<p>{`${__('Career', 'movie-library')}: ${careerName}`}</p>
		</>
	);
}
