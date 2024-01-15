import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';

/**
 * Component for controlling the count of persons to display.
 *
 * This component renders an input field for setting the count of persons to display
 * within a specified range (0 - 10).
 *
 * @param {Object}   props          - The properties passed to the CountControl component.
 * @param {Function} props.setCount - A function to set the count of persons.
 * @param {number}   props.count    - The current count of persons.
 * @return {JSX.Element} JSX element representing the count control.
 */
export default function CountControl({ setCount, count }) {
	const [randomID] = useState(Math.floor(Math.random() * 1e5));
	return (
		<fieldset>
			<legend>{__('Select Count', 'movie-library')}</legend>
			<div>
				<label htmlFor={`${randomID}_count_input`}>
					{__('Number of persons (0 - 10)', 'movie-library')}
				</label>
				<br />
				<br />
				<input
					type="number"
					step={1}
					value={count}
					id={`${randomID}_count_input`}
					onChange={(evt) => setCount(evt.target.value)}
					min={1}
					max={10}
				/>
			</div>
		</fieldset>
	);
}
