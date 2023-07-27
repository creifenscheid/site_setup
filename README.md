# Site Setup

This TYPO3 extension provides the configuration to set up a webpage. 
It does not offer any styling.

## Features

### Instance configuration 

Using the constant editor you‘ll get a bunch of configuration possibilities such as:

* Various icons, e.g. app icon, icons in carousel action buttons, favicon etc. 
* Path to the logo to use in templates 
* Name of templates to use to render the page
* ID of main menu and footer menu container Pages

The extension sets the following configurations via typoscript:

* Compression of css and js
* Concatenation of css and js
* Title tag incl. configured postfix
* App and fav icon
* meta data
  * viewport
  * description
  * last modification 
  * mobile Web App configuration 

### Templating / Frontend

This extension comes along with some ready-to-use partials, e.g. for menus, skip links, content rendering etc., always by providing the maximum amount of accessibility.
Note that the submenus, which are rendered in the main menu (if "dontRenderChildren" flag is not set), are not initialized, they are just rendered with some basic classes.
It's recommended to overwrite the toggle button partial with the needed classes and button content without removing the aria-attributes.

Besides partials there are a some typoscript libraries to use, e.g. inline svg rendering, rendering of an "attention icon" or colpos rendering and many more.

### Extension of page properties

* implements configuration for auto toc rendering

### Content Elements

The extension implements the following content Elements in addition to the TYPO3 standard. 

#### Table of contents

* List of headlines on the current page
* Nested list structure to represent the heading structure of the page
* linked list Elements to quickly navigate to the desired part of the page
* configuration of listed headline levels (h2 - h6)
* note: RTE headlines are not supported

#### Last page edit

* rendering of the creation and last modification date of the page
* no configuration, the outputted sentence is hard coded 

#### Carousel

* implementation of an image carousel
* using javascript library „swiper“
* minimal configuration 
  * images to show at once (for tablet and larger screens)
  * enable/disable autoplay
  * speed of duration
* frontend comes along with buttons for the following actions
  * previous image 
  * next image
  * start carousel 
  * stop carousel

### Third party libraries

The extension comes a long with the following frameworks:

* parvus: accessible lightbox
* swiperjs: accessible carousel

All libraries are included locally and not via cdn or something. 
This is done to prevent privacy issues. 
Therefor the delivered frameworks may not be the latest release.