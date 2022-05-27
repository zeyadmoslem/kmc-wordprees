/**
 * BLOCK: kmc-blocks
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './editor.scss';
import './style.scss';

import apiFetch from '@wordpress/api-fetch';
import parse from 'html-react-parser';


const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType('kmc/services', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __('kmc-blocks - Services'), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [__('kmc-blocks — Services')],
	attributes: {
		services: {
			type: 'object',
		},
	},
	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Component.
	 */
	edit: (props) => {

		if (!props.attributes.services) {
			apiFetch({ path: '/services/v1/all' }).then((data) => {
				props.setAttributes({
					services: data
				});
			});
		}


		if (!props.attributes.services) {
			return "Loading...";
		}

		if (props.attributes.services && props.attributes.services === 0) {
			return "No Services found";
		}
		console.log(props.attributes.services);

		return (
			<div class="row p-4">
				{
					props.attributes.services.map(service => {
						return (
							<div className="col-4 services-item p-3">
								<span>{parse(service.icon)}</span>
								<h4>{service.title}</h4>
								<p>{service.description}</p>
								<a  className="gutentor-button gutentor-block-button gutentor-icon-after"
									href={service.link}>
									 <i class="gutentor-button-icon fas fa-long-arrow-alt-right"></i>
									 <span>Mehr erfahren</span>
								</a>
							</div>
						)
					})
				}
			</div>
		);
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Frontend HTML.
	 */
	save: (props) => {
		return null;
	},
});
