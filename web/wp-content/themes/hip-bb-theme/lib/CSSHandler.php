<?php
/**
 * CCS Handler
 *
 * Determines CSS files to load and rather they should be inlined or deferred.
 */

class CSSHandler
{
	protected $css_dir;
	protected $css_uri;
	protected $version;
	
	protected $stylesheets = [];

	protected $inline_postfix = '-inline.css';
	protected $deferred_postfix = '-deferred.css';

	public function __construct($css_dir, $css_uri, $version)
	{
				
		$this->css_dir = $css_dir;
		$this->css_uri = $css_uri;
		$this->version = $version;
	}
	
	public function setTemplateStyles()
	{
		$postfixes = [ 'inline' => $this->inline_postfix, 'deferred' => $this->deferred_postfix ];

		foreach ($postfixes as $key => $postfix) {
			if (file_exists($this->css_dir . '/global' . $postfix)) {
				$this->addStyle($this->buildStylePath('global', $key, $postfix), $key);
			}

			if (is_404()) {
				if (file_exists($this->css_dir . '/404' . $postfix)) {
					$this->addStyle($this->buildStylePath('404', $key, $postfix), $key);
				}
				continue;
			}

			if (file_exists($this->css_dir . '/' . get_post_type() . $postfix)) {
				$this->addStyle($this->buildStylePath(get_post_type(), $key, $postfix), $key);
			}

			if (get_page_template_slug()) {
				$sluginfo = pathinfo(get_page_template_slug());
				$template = $sluginfo['filename'];
				if (file_exists($this->css_dir . '/' . $template . $postfix)) {
					$this->addStyle($this->buildStylePath($template, $key, $postfix), $key);
				}
			}

			if (is_front_page()) {
				if (file_exists($this->css_dir . '/front-page' . $postfix)) {
					$this->addStyle($this->buildStylePath('front-page', $key, $postfix), $key);
				}
			}

			if (is_blog()) {
				if (file_exists($this->css_dir . '/blog' . $postfix)) {
					$this->addStyle($this->buildStylePath('blog', $key, $postfix), $key);
				}
			}
		}
	}
	
	public function buildStylePath($name, $type, $postfix)
	{
		if ($type == 'inline') {
			return $this->css_dir . '/' . $name . $postfix;
		} elseif ($type == 'deferred') {
			return $this->css_uri . '/' . $name . $postfix;
		}
	}
	
	public function addStyle($stylesheet, $type)
	{
		$this->stylesheets[$type][] = $stylesheet;
	}
	
	public function getInlineCSS()
	{
		$css = '<style type="text/css">';

		if (is_array($this->stylesheets['inline'])) {
			foreach ($this->stylesheets['inline'] as $stylesheet) {
				$css .= file_get_contents($stylesheet, true);
			}
		}

		$css .= '</style>';

		echo $css;
	}

	public function getDeferredCSS()
	{
		?>

		<noscript id="deferred-styles">
			<?php if (array_key_exists('deferred', $this->stylesheets)) :
				foreach ($this->stylesheets['deferred'] as $stylesheet) { ?>
					<link rel="stylesheet" type="text/css" href="<?php echo $stylesheet . '?v=' . $this->version ?>" />
				<?php }
			endif; ?>
		</noscript>
		<script>
			( function() {
				var loadDeferredStyles = function() {
					var addStylesNode = document.getElementById("deferred-styles");
					var replacement = document.createElement("div");
					replacement.innerHTML = addStylesNode.textContent;
					document.body.appendChild(replacement)
					addStylesNode.parentElement.removeChild(addStylesNode);
				};
				var raf = requestAnimationFrame || mozRequestAnimationFrame || webkitRequestAnimationFrame || msRequestAnimationFrame;
				if (raf) raf( function() { window.setTimeout( loadDeferredStyles, 0 ); } );
				else window.addEventListener('load', loadDeferredStyles);
			} )();
		</script>

		<?php
	}
}
