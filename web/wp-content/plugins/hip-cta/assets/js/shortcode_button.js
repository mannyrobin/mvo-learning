(function() {

	tinymce.PluginManager.add('hipcta', function( editor )
	{
		var hipctaValues = [];
		jQuery.each(hipcta_all_ctas, function( key, value)
		{
				hipctaValues.push({text: value, value:key});
		});

		editor.addButton('hipcta', {
				type: 'listbox',
				text: 'Calls to Action',
				onselect: function(e) {
						var v = e.control.settings.value;

						tinyMCE.activeEditor.selection.setContent( '[hip-cta id=' + v + ']' );
				},
				values: hipctaValues
		});
	});
})();
