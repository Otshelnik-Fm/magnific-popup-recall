== Install/Update ==

<h3 style="text-align: center;">Install:</h3>
This add-on for WordPress plug-in <a href="https://wordpress.org/plugins/wp-recall/" target="_blank">WP-Recall</a>
This add-on is installed through the WP-Recall add-on manager:

1. In the admin area of your site, go to the page: "WP-RECALL" -> "Add-ons"
2. At the top, where "Install the add-on to WP-Recall format .ZIP" - click on the "browse" button, select the .zip archive add-on on your PC and click "Install."
3. In the add-ons list, on this page below, find this add-on, hover your mouse over it, and click the "Activate" button.



<h3 style="text-align: center;">Update:</h3>
The add-on supports automatic updating - requests for updates are sent to your server twice a day.
You can launch the update by clicking the link in the new version banner (if it's there) on the page: "WP-RECALL" -> "Add-ons"




== FAQ ==

<h4> How do I exclude an image from gallery work?</h4>

- In order for the image not to participate in Magnific Popup Recall magnification (and opened in the browser window), specify the class in the <code>"a"</code> tag: <code>class="nomagnific"</code>

<hr style="border: 1px solid #ddd;">


<h4>I paste the image - but it does not increase. What's wrong?</h4>

- It is important that you insert an image from the WordPress media library marked as a "Media file"
In the media library, select the "Media file" <a href="https://yadi.sk/i/OVWHsS5N3YAAzG" target="_blank">Screenshot</a>

ie, if you look at the source code of the page, the image must be inside the tag <code>&lt;a</code>
So: <code>&lt;a href=&quot;http://link-to-full-picture.jpg&quot;&gt;&lt;img src=&quot;http://link-to-thumbnail.jpg&quot;/&gt;&lt;/a&gt;</code>

<hr style="border: 1px solid #ddd;">


<h4>My pictures are loaded with ajax-script, but the gallery does not see them. Opens them in a separate window</h4>

- The script processes images that were loaded along with the html page. If ajax is then loaded with new data, it will not see them. 
There is a way out - after successfully loading ajax you need to reinitialize the script:
Just call in your script, after the ajax-request, the js function: <code>MpActivate();</code>

<hr style="border: 1px solid #ddd;">


<h4>The images in the Prime Forum are dying. How to turn off one gallery?</h4>

- To make the site use a single gallery - in the options of PrimeForum, disable the option "Image Gallery": "PrimeForum" -> "Settings" -> "Image Gallery" - disabled

<hr style="border: 1px solid #ddd;">




== Changelog ==

= 2018-06-20 =
v1.3
* Multilanguage support
* Added translations into 8 languages: Russian, English, Ukrainian, German, Italian, Spanish, French, Romanian
* Added add-on icon
* Styles, are not critical for the 1st screen, so I'll load them in footer.
* Styles from core magnific minimized
* The animation is translated to the core of WP-Recall (animate-css)


= 2017-09-05 =
v1.2
* Supports "Prime Image Uploader" for "PrimeForum"
- To make the site use a single gallery - in the settings of PrimeForum turn off the option "Image Gallery": "PrimeForum" -> "Settings" -> "Image Gallery" - disabled


= 2017-08-14 =
v1.1
* The initialization script for the main gallery script is wrapped in the <code>MpActivate();</code> function;
it is convenient to once again initialize the gallery for example after the content was loaded with ajax
How to work with this? after successful completion of the ajax-request call the function <code>MpActivate();</code>
* The styles of the main script are now combined with the style file of the add-on: minus 1 request to the server.


= 2016-11-04 =
v1.0
* Release




== Misc ==
* Support is provided within the current functionality of the add-on
* If you have a problem, create an appropriate topic on the product support forum.
* If you need to customize for your needs - you can contact me <a href="https://en.codeseller.ru/author/otshelnik-fm/?tab=chat" target="_blank">in personal messages</a> with technical requirements for a paid upgrade.

All my works have been published by <a href="https://otshelnik-fm.ru/?p=2562" target="_blank">on my site</a> and in the store's catalog <a href="https://en.codeseller.ru/author/otshelnik-fm/?tab=publics&subtab=type-products" target="_blank">en.CodeSeller.ru</a>

