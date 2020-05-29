( function( editor, components, i18n, element ) {
	const el = element.createElement,
		  registerBlockType = wp.blocks.registerBlockType,
		  BlockControls = wp.editor.BlockControls,
		  AlignmentToolbar = wp.editor.AlignmentToolbar,
		  InspectorControls = wp.editor.InspectorControls,
		  SelectControl = wp.components.SelectControl,
		  allVideos = [],
		  videoSelectOptions = [{label:'Select From Below',value:0}];

	$.ajax({
		method: 'GET',
		url: blockInfo.restUrl,
		dataType: 'json',
	}).then(function(r){
		for(let i=0; i<r.length;i++){
			let video = r[i];
			allVideos.push(video);
			videoSelectOptions.push({label:convertCharCodes(video.title.rendered),value:video.id});
		}
	});
	const convertCharCodes = function(str){
		return str.replace(/&#(\d{0,4});/g, function(fullStr, str) {
			return String.fromCharCode(str);
		});
	};

	const VideoBlock = function (videos){
		this.allVideo   = videos;
		this.id         = null;
		this.selected   = {};
	};
	VideoBlock.prototype.setId = function (id) {
		this.id = id;
		return this;
	};

	VideoBlock.prototype.getId = function () {
		return this.id;
	};
	VideoBlock.prototype.setVideo = function () {
		for(let i=0; i<this.allVideo.length; i++){
			if(this.allVideo[i].id === this.id){
				this.selected = this.allVideo[i]
			}
		}
		return this;
	};
	VideoBlock.prototype.getVideoEmbedId = function () {

		let regExp = /.+\/([a-zA-Z0-9_\-]+)\/*$/,
			videoUrl = this.selected.video_meta.video_embed;

		if(videoUrl.length > 0){
			let match = videoUrl.match(regExp);
			if (match) {
				return match[1];
			}
		}
		return false;
	};
	VideoBlock.prototype.getVideoTitle = function() {

		if(this.selected.video_meta.display_title.length > 0){
			return this.selected.video_meta.display_title;
		}

		return this.selected.title.rendered;
	};
	VideoBlock.prototype.getScreenshot = function() {

		return this.selected.video_meta.screenshot;
	};
	VideoBlock.prototype.getVideoDescription = function () {
		if(this.selected.content.rendered.length > 0)
			return this.selected.content.rendered.replace(/(<([^>]+)>)/ig,"");

		return '';
	};
	VideoBlock.prototype.getResponsivePadding = function() {
		if(this.selected.video_meta.responsive_padding.length > 0)
			return this.selected.video_meta.responsive_padding;

		return 56.25;
	};
	VideoBlock.prototype.initBlock = function(id){
		this.setId(parseInt(id)).setVideo();
	};
	const videoBlock = new VideoBlock(allVideos);

	registerBlockType( 'hvc-video-block/video-from-collection', {
		title: i18n.__( 'Video from collection' ),
		description: i18n.__( 'Custom block for displaying a video form video collection' ),
		icon: 'video-alt3',
		category: 'common',
		attributes: {
			title: {
				type: 'string',
				default: 'Video title'
			},
			alignment: {
				type: 'string',
				default: 'center',
			},
			videoId: {
				type: 'number',
				default: 0
			},
			titlePos: {
				type: 'string',
				default: 'bottom'
			},
			showDesc: {
				type: 'string',
				default: 'no'
			},
			description : {
				type : 'string',
				default: 'Video description'
			},
			screenshot: {
				type: 'string',
				default: blockInfo.assetsUrl+'img/hvc-placeholder.jpg'
			},
			responsivePadding : {
				type: 'number',
				default: '56.25'
			},
			embedId : {
				type : 'string'
			}

		},

		edit: function( props ) {

			let attributes = props.attributes,
				alignment = props.attributes.alignment,
				titlePos = props.attributes.titlePos,
				videoId = props.attributes.videoId,
				showDesc = props.attributes.showDesc;

			const onChangeAlignment = function ( newAlignment ) {
				props.setAttributes({ alignment: newAlignment });
			};
			return [
				el( BlockControls, { key: 'controls' },
					el( AlignmentToolbar, {
						value: alignment,
						onChange: onChangeAlignment,
					})
				),
				el( InspectorControls, { key: 'inspector' },
					el( components.PanelBody, {
							title: i18n.__( 'Options' ),
							className: 'hvc-block-options',
							initialOpen: true,
						},
						el( SelectControl,{
							type: 'string',
							label: i18n.__( 'Select Video' ),
							value: videoId,
							options: videoSelectOptions,
							onChange: function( newvideoId ) {
								if(parseInt(newvideoId) === 0){
									props.setAttributes({videoId: 0});
									props.setAttributes({title : 'Video title'});
									props.setAttributes({screenshot:blockInfo.assetsUrl+'img/hvc-placeholder.jpg'});
									props.setAttributes({description: 'Video description'});
								}else{
									videoBlock.initBlock(newvideoId);
									props.setAttributes({videoId: videoBlock.getId()});
									props.setAttributes({title : videoBlock.getVideoTitle()});
									props.setAttributes({screenshot:videoBlock.getScreenshot()});
									props.setAttributes({description: videoBlock.getVideoDescription()});
									props.setAttributes({responsivePadding: videoBlock.getResponsivePadding()});
									props.setAttributes({embedId: videoBlock.getVideoEmbedId()});
								}
							},
						}),
						el( SelectControl,{
							type: 'string',
							label: i18n.__( 'Title Position' ),
							value: titlePos,
							options: [{label:'Top',value:'top'},{label:'Bottom',value:'bottom'},{label:'Hide',value:'hide'}],
							onChange: function( newTitlePos ) {
								props.setAttributes( { titlePos: newTitlePos });
							},
						}),
						el( SelectControl,{
							type: 'string',
							label: i18n.__( 'Show Description' ),
							value: showDesc,
							options: [{label:'No',value:'no'},{label:'Yes',value:'yes'}],
							onChange: function( newShowDesc ) {
								props.setAttributes( { showDesc: newShowDesc });
							},
						})
					),
				),
				el( 'div', {key:'video-block-container', className: props.className },
					el( 'div',{className: 'pps-video-wrap',style: { textAlign: alignment }},
						(function() {
							if(titlePos === 'top'){
								return el('h3', {className: 'pps-video-preview-title'},attributes.title)
							}
						}()),
						el('div',{className: 'pps-video-preview-wrap'},
							el('a',{
								href: '#vidpopup-'+attributes.videoId,
								id:'preview-'+attributes.videoId,
								className: 'preview-video'
							},
								el( 'img', {
									src: attributes.screenshot
								}),
								el('span',{className:'push-btn'},
									el('i',{className:'dashicons dashicons-controls-play'})
								)
							)
						),
						(function() {
							if(titlePos === 'bottom'){
								return el('h3', {className: 'pps-video-preview-title'}, attributes.title)
							}
						}()),
						(function(){
							if(showDesc === 'yes'){
								if(attributes.description.length > 0){
									return el('p',{}, attributes.description);
								}
							}
						}())
					),
				)
			];
		},

		save: function( props ) {
			let attributes = props.attributes;

			return (
				el('div',{key:'video-block-output',className : 'video-block',style: { textAlign: attributes.alignment}},
					el('div',{className: 'pps-video-wrap'},
						(function() {
							if(attributes.titlePos === 'top'){
								return el('h3', {className: 'pps-video-preview-title'},attributes.title);
							}
						}()),
						el('div',{className: 'pps-video-preview-wrap'},
							el('a',{
									href: '#vidpopup-'+attributes.videoId,
									id:'preview-'+attributes.videoId,
									className: 'preview-video'
								},
								el( 'img', {
									src: attributes.screenshot
								}),
								el('span',{className:'push-btn'},
									el('i',{className:'dashicons dashicons-controls-play'})
								)
							)
						),
						(function() {
							if(attributes.titlePos === 'bottom'){
								return el('h3', {className: 'pps-video-preview-title'},attributes.title)
							}
						}()),
						(function(){
							if(attributes.showDesc === 'yes'){
								return el('p',{}, attributes.description)
							}
						}()),
					),
					el('div',{id : 'vidpopup-'+attributes.videoId,className : 'pvc-lightbox'},
						el('h2', {className: 'pps-video-title'},attributes.title),
						el('div',{className: 'hvc-video', style: { paddingTop: attributes.responsivePadding+'%'}},
							el('iframe',{
								id:'iframe-'+attributes.videoId,
								type:'text/html',
								width:640,
								height:360,
								src: 'https://www.youtube.com/embed/'+attributes.embedId+'?enablejsapi=1&rel=0'
							})
						),
						(function(){
							if(attributes.showDesc === 'yes'){
								return el('p',{className: 'hvc-popup-desc'}, attributes.description)
							}
						}()),
					),
					el('script',{
						type:'text/javascript',
					}, "jQuery(document).ready(function ($) {$('a#preview-"+attributes.videoId+"').popup({backClass: 'vid_popup_back',containerClass: 'vid_popup_cont',afterOpen: function () {var player = new YT.Player('iframe-"+attributes.videoId+"', {events: {'onReady': onPlayerReady}});function onPlayerReady(event) {if (!(/Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent))) {event.target.playVideo();}}}});});"
					)
				)
			);
		},
	});

})(
	window.wp.editor,
	window.wp.components,
	window.wp.i18n,
	window.wp.element,
);
