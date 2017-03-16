( function( $ ) {

	/**
	 * Handles frontend editing UI logic for the builder.
	 *
	 * @class FLThemeBuilderFrontendEdit
	 * @since 1.0
	 */
	var FLThemeBuilderFrontendEdit = {

		/**
		 * Initialize.
		 *
		 * @since 1.0
		 * @access private
		 * @method _init
		 */
		_init: function()
		{
			this._bind();
		},

		/**
		 * Bind events.
		 *
		 * @since 1.0
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			$( '.fl-builder-content:not(.fl-builder-content-primary)' ).on( 'mouseenter', this._partMouseenter );
			$( '.fl-builder-content:not(.fl-builder-content-primary)' ).on( 'mouseleave', this._partMouseleave );
		},

		/**
		 * Shows the edit overlay when the mouse enters a
		 * header, footer or part.
		 *
		 * @since 1.0
		 * @access private
		 * @method _partMouseenter
		 */
		_partMouseenter: function()
		{

		},

		/**
		 * Removes the edit overlay when the mouse leaves a
		 * header, footer or part.
		 *
		 * @since 1.0
		 * @access private
		 * @method _partMouseleave
		 */
		_partMouseleave: function()
		{

		}
	};

	// Initialize
	$( function() { FLThemeBuilderFrontendEdit._init(); } );

} )( jQuery );
