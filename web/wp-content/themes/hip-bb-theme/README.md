# Hip Beaver Builder Theme

This is a very generic theme meant to be used in conjunction with Beaver Themer.

## Built-in Templates

There are several built-in theme layouts and templates that can be used. Right now, that list includes:

- Three Header Layouts
- Three Footer Layouts
- Blog Archive Layout
- Single Post Layout
- Search Results Layout 
- Brand Standards template
- A Full Height Hero Row

To use pre-built templates, you must create a post ( for templates ) or a theme layout ( for layouts ). Open the new post in Beaver Builder, click "Templates" in top right corner, then select the desired template. At the moment, all templates are listed under "Uncategorized."

To save a new pre-built template, follow the guide on [Beaver Builder Knowledge Base](http://kb.wpbeaverbuilder.com/article/107-theme-author-templates). Templates are stored in 'web/app/themes/hip-bb-theme/templates'. 

## Theme Parts 

The following parts are defined by theme: 

- Before Header (before_header)
- Header
- After Header (after_header)
- Banner (hip_bb_banner)
- Breadcrumbs (hip_bb_breadcrumb)
- After Contect (hip_bb_after_content)
- Before Footer (before_footer)
- Footer
- After Footer (after_footer)

Each of these parts can be assigned a theme layout in Beaver Themer or treated as a standard WordPress action hook. This gives you plenty of flexibility in designing child themes.

## Hip Settings 

Hip settings have some settings options for all the theme.

#### General Settings:

**Logo**

There are two way to add site logo. Logo image Upload option or if logo image not available, SVG html will be add for site logo. For frontend, logo will be display by shortcode  `[hip_logo]`

If Site are available Alternative logo therefore use  Alternative logo upload option or svg html logo option.For frontend, alternative  logo will be display by shortcode `[hip_alt_logo]`

**Fonts Style**

There is a option for setting body fonts globally. You can use any google font from the dropdown and also define its weight and size.

You can also set heading font family and font weight from this section. This settings will be applied on all heading fonts.

>**Note:** 300, 400 and 700 (if available in google) font weight will be available for all selected fonts.

**Colors**

You can define site color scheme from this section. available settings are: 

- Primary color 
- Primary Highlight color
- Secondary color
- Secondary highlight color
- Body font color
- Link color
- Link hover color

By default all headings of the site will be primary color. There are also some pre build css class using this color settings for Beaver Builder and use in custom code. These are:

 *For Beaver Builder*
 
 - With primary color: `primary-heading`, `text-primary`, `text-primary-highlight`, `primary-btn`, `primary-bg`, `primary-bg-highlight`
 - With secondary color: `secondary-heading`, `text-secondary`, `text-secondary-highlight`, `secondary-btn`, `secondary-bg`, `secondary-bg-highlight`
 
  *For Use in custom html code*
  
  - With primary color: `primary-txt`, `primary-txt-highlight`, `bg-primary`, `button-primary`
  - With secondary color: `secondary-txt`, `secondary-txt-highlight`, `bg-secondary`, `button-secondary`
  
**Button**

You can style custom button from this section. For using this button style add `general-btn` css class in Beaver builder module. For custom HTML code use `btn-general` css class.

>**Note:** Buttton classes( `primary-btn`, `secondary-btn`, `general-btn` ) can be used in the following Beaver Builder modules: Button module, Post modules(carousel, grid, slider), Callout, Call to action, Content slider, Wpforms widget.
        
 
#### Business info Settings:

**Phone Number**

You can insert your business phone number in this field. Currently supports only USA phone numbers. There is also a field connection with beaver themer named `businessinfo_phone_number`. To display manually you can use shortcode `[hip_phone]`.

**Address**

Insert your main business address in this field. For use in frontend use shortcode `[hip_address]`

**Social Media**

 Social media Icons and link fields are available for set social media icon and link. The social media icons will be available by a font-awesome icon class. For display in frontend use shortcode `[hip_social_icons]`
