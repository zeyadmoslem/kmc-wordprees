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
registerBlockType('kmc/doctors', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __('kmc-blocks - Doctors'), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [__('kmc-blocks — Doctors')],
	attributes: {
		doctors: {
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

		if (!props.attributes.doctors) {
			apiFetch({ path: '/doctors/v1/all' }).then((data) => {
				props.setAttributes({
					doctors: data
				});
			});
		}


		if (!props.attributes.doctors) {
			return "Loading...";
		}

		if (props.attributes.doctors && props.attributes.doctors === 0) {
			return "No News found";
		}
		console.log(props.attributes.doctors);

		return (
			<div class="row p-4">
				{
					props.attributes.doctors.map(doctor => {
						return (
							<div class="col-xs-6 col-sm-6 col-md-3 doctors-item p-3">
								<div class="item-card">
									<div class="top">
									</div>
									<div class="center">
										<img src={doctor.image} alt="img-responsive" />
									</div>
									<div class="bottom">
										<h3>{doctor.title}</h3>
										<p>{doctor.description}</p>
									</div>
								</div>
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
