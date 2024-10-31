=== Postadv ===
Contributors: ugene, sachyya-sachet
Donate link: #
Tags: Google Adsense, google, plugin, adsense, insert adsense, adsense ad, ad code, adsense shortcode, insert ad, ads, adsense plugin, advertising
Requires at least: 4.5
Tested up to: 4.8
Stable tag: 1.0.2
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

A simple WordPress plugin that helps you to add the AdSense script in your desired location as post content using shortcode and latency option.

== Description ==
PostAdv is a plugin that lets you add AdSense script anywhere in the post content. It also has one additional latency option to delay the adv from showing up on published posts for the first n days after they are published.

Usages
Backend

	1. After installing the plugin, you will find a Postadv menu under Settngs
	2. The page has basic settings like
		a. textarea for adding script.
		b. Hide In option
		c. enabling/disabling latency
		d. if enabled, num field to add days in number
	3. It also adds a meta box in each post for adding script. This has higher priority than the one in the setting page.

Frontend

	1. Shortcode: To use in the frontend, you have to add [postadv] shortcode in the editor, your desired location.
	2. Parameters: There are few paramteres that can be used according to your requirement and overrides all the options of settings page
	    a. [postadv hidein="nohide/desktop/mobile"], "nohide" does not hide in any screens, "desktop" hides in desktop and if "mobile" is selected, the adsense will hide in mobile devices.
		b. [postadv latency="on/off"]
		c. [postadv latency="on" latency_day="n"], where n is the integer 1,2,3, ......n
		Note: Use these options only if you want to override the ones from the settings page.

= Notes =
1. Hide In, there are three options (Do not hide, Hide in Desktop, Hide in Mobile)
2. Disabling latency means, the AdSense will simply display without any condition where the shortcode is used.
3. Enabling latency means, the AdSense will dispaly on the defined latency day from the day the post was published.
4. Enabling or tickmarking the MCU option will disable all shortcode at once. No need to manually go and remove the shortcode used in hundreds of posts.

== Installation ==
1. Download and copy paste the files in the plugin folder of your WordPress.

== Frequently Asked Questions ==
= Do I have to use shortcode? =
Yes, it is all based on the shortcode and it has to be used.

== Screenshots ==
1. Backend Settings page
2. Backend Post meta

== Changelog ==
= 1.0.2 =
1. Whitlisted the display attribute of <ins> inline style
2. Allowed the "data-ad-format" attr of <ins>
3. Added new "Hide In" options (Do no hide, Desktop, Mobile). This can also be overridden by shortcode parameters.

= 1.0.1 =
1. Added new MCU switch to disable all the shortcodes at once.
2. Fix the latency time evaluation issue
3. Fix the conflict with the save_post hook
4. Fix the issue in overriding inner post meta script

= 1.0.0 =
First Version