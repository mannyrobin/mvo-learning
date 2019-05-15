<#

var field = data.field,
    name = data.name,
    value = JSON.stringify( data.value );
	accept = '';
	button_text = '<?php echo 'Upload'; ?>';

	if ( typeof field.accept !== 'undefined' ) {
		accept = ' accept=' + field.accept;
	}
	if ( typeof field.button_text !== 'undefined' ) {
		button_text = field.button_text;
	}
#>
<input type="file" class="pp-field-file" name="{{name}}_file"{{accept}} />
<input type="hidden" name="{{name}}" value="{{value}}" />
<a href="javascript:void(0)" class="pp-field-file-upload">{{{button_text}}}</a>
<# if ( '' !== data.value ) { #>
<div class="pp-field-file-msg"><?php _e(' Currently showing data from <strong>{{data.value.filename}}</strong>' ); ?></div>
<# } #>