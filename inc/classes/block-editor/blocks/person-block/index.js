import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';

import './editor.scss';
import './style.scss';
import { Edit } from './edit';

registerBlockType(metadata.name, {
	edit: Edit,
});
