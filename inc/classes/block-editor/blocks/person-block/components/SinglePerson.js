import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * Component for displaying a single person item.
 *
 * This component displays details of a single person item, including its title,
 * thumbnail,  career.
 *
 * @param {Object} props           - The properties passed to the SinglePerson component.
 * @param {string} props.title     - The title of the person.
 * @param {string} props.thumbnail - The URL of the person's thumbnail image.
 * @param {Array}  props.careers   - The array of person's careers.
 * @return {JSX.Element} JSX element representing a person item.
 */
export default function SinglePerson({ title, thumbnail, careers }) {
	const [careerNames, setCareerNames] = useState([]);

	// Select the information about the careers for the person.
	const { careerRecords, haveCareersResolved } = useSelect((select) => {
		if (!Array.isArray(careers)) {
			return {
				careerRecords: [],
				haveCareersResolved: true,
			};
		}

		const include = careers.slice(0, 2);

		const selectorArgs = ['taxonomy', 'mlib-person-career', { include }];
		return {
			careerRecords: select(coreDataStore).getEntityRecords(
				...selectorArgs
			),
			haveCareersResolved: select(coreDataStore).hasFinishedResolution(
				'getEntityRecords',
				selectorArgs
			),
		};
	});

	// Set Career names if resolved.
	useEffect(() => {
		if (!haveCareersResolved) {
			return;
		}
		setCareerNames(
			careerRecords.map((career) => decodeEntities(career.name))
		);
	}, [haveCareersResolved]);

	return (
		<div className="movie-library-single-person">
			<img src={thumbnail} alt={title} />
			<p>{`${__('Title', 'movie-library')}: ${title}`}</p>
			<p>{`${__('Career', 'movie-library')}: ${careerNames.join(
				', '
			)}`}</p>
		</div>
	);
}
