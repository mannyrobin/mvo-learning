(function($){

	/**
	 * Helper class for header layout logic.
	 *
	 * @since 1.0
	 * @class FLThemeBuilderHeaderLayout
	 */
	FLThemeBuilderHeaderLayout = {

		/**
		 * A reference to the window object for this page.
		 *
		 * @since 1.0
		 * @property {Object} win
		 */
		win : null,

		/**
		 * A reference to the body object for this page.
		 *
		 * @since 1.0
		 * @property {Object} body
		 */
		body : null,

		/**
		 * A reference to the header object for this page.
		 *
		 * @since 1.0
		 * @property {Object} header
		 */
		header : null,

		/**
		 * Initializes header layout logic.
		 *
		 * @since 1.0
		 * @method init
		 */
		init: function()
		{
			var editing = $( 'html.fl-builder-edit' ).length,
				header  = $( 'header.fl-builder-content' );

			if ( ! editing && header.length ) {

				this.win    = $( window );
				this.body   = $( 'body' );
				this.header = header.eq( 0 );

				if ( Number( header.attr( 'data-sticky' ) ) ) {

					this.win.on( 'resize', $.throttle( 500, $.proxy( this._initSticky, this ) ) );
					this._initSticky();

					if ( Number( header.attr( 'data-shrink' ) ) ) {
						this.win.on( 'resize', $.throttle( 500, $.proxy( this._initShrink, this ) ) );
						this._initShrink();
					}
				}
			}
		},

		/**
		 * Initializes sticky logic for a header.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initSticky
		 */
		_initSticky: function()
		{
			if ( this.win.width() >= FLBuilderLayoutConfig.breakpoints.medium ) {
				this.header.addClass( 'fl-theme-builder-header-sticky' );
				this.body.css( 'padding-top', this.header.outerHeight() + 'px' );
			} else {
				this.header.removeClass( 'fl-theme-builder-header-sticky' );
				this.body.css( 'padding-top', '0' );
			}
		},

		/**
		 * Initializes shrink logic for a header.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initShrink
		 */
		_initShrink: function()
		{
			if ( this.win.width() >= FLBuilderLayoutConfig.breakpoints.medium ) {
				this.win.on( 'scroll.fl-theme-builder-header-shrink', $.proxy( this._doShrink, this ) );
			} else {
				this.body.css( 'padding-top', '0' );
				this.body.removeClass( 'fl-theme-builder-body-shrink' );
				this.win.off( 'scroll.fl-theme-builder-header-shrink' );
				this._removeShrink();
			}
		},

		/**
		 * Shrinks the header when the page is scrolled.
		 *
		 * @since 1.0
		 * @access private
		 * @method _doShrink
		 */
		_doShrink: function()
		{
			var top    = this.win.scrollTop(),
				height = parseInt( this.body.css( 'padding-top' ) );

			if ( top > height ) {

				if ( ! this.header.hasClass( 'fl-theme-builder-header-shrink' ) ) {

					this.header.attr( 'data-original-height', this.header.outerHeight() );
					this.header.addClass( 'fl-theme-builder-header-shrink' );
					this.body.addClass( 'fl-theme-builder-body-shrink' );
					this.body.css( 'padding-top', '0' );

					this.header.find( '.fl-row-content-wrap' ).each( function() {

						var row = $( this );

						if ( parseInt( row.css( 'padding-bottom' ) ) > 5 ) {
							row.addClass( 'fl-theme-builder-header-shrink-row-bottom' );
						}

						if ( parseInt( row.css( 'padding-top' ) ) > 5 ) {
							row.addClass( 'fl-theme-builder-header-shrink-row-top' );
						}
					} );

					this.header.find( '.fl-module-content' ).each( function() {

						var module = $( this );

						if ( parseInt( module.css( 'margin-bottom' ) ) > 5 ) {
							module.addClass( 'fl-theme-builder-header-shrink-module-bottom' );
						}

						if ( parseInt( module.css( 'margin-top' ) ) > 5 ) {
							module.addClass( 'fl-theme-builder-header-shrink-module-top' );
						}
					} );
				}
			} else if ( this.header.hasClass( 'fl-theme-builder-header-shrink' ) ) {
				this.body.css( 'padding-top', this.header.attr( 'data-original-height' ) + 'px' );
				this._removeShrink();
			}
		},

		/**
		 * Removes the header shrink effect.
		 *
		 * @since 1.0
		 * @access private
		 * @method _removeShrink
		 */
		_removeShrink: function()
		{
			var rows    = this.header.find( '.fl-row-content-wrap' ),
				modules = this.header.find( '.fl-module-content' );

			rows.removeClass( 'fl-theme-builder-header-shrink-row-bottom' );
			rows.removeClass( 'fl-theme-builder-header-shrink-row-top' );
			modules.removeClass( 'fl-theme-builder-header-shrink-module-bottom' );
			modules.removeClass( 'fl-theme-builder-header-shrink-module-top' );
			this.header.removeClass( 'fl-theme-builder-header-shrink' );
		}
	};

	$( function() { FLThemeBuilderHeaderLayout.init(); } );

})(jQuery);
