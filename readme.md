Intallation Note
===================
1. Download and copy paste the files in the plugin folder of your WordPress.

Usages
===================

Backend

	1. After installing the plugin, you will find a Postadv menu under Settngs
	2. The page has basic settings like
		a. textarea for adding script.
		b. enabling/disabling latency
		c. if enabled, num field to add days in number
	3. It also adds a meta box in each post for adding script. This has higher priority than the one
	in the setting page.

Frontend

	1. Shortcode: To use in the frontend, you have to add [postadv] shortcode in the editor, your desired location.
	2. Parameters: There are few paramteres that can be used according to your requirement
		a. [postadv latency="on/off"]
		b. [postadv latency="on" latency_day="n"], where n is the integer 1,2,3, ......n
		Note: Use these options only if you want to override the ones from the settings page. 

Notes
====================
1. Disabling latency means, the AdSense will simply display without any condition where the shortcode is used. 
1. Enabling latency means, the AdSense will dispaly on the defined latency day from the day the post was published.
