#Pvl CheckIf

Pvl Checkif is an ExpresionEngine plugin that checks if a value is in a list (default separator: |) or if it isn't.

This plugin can also check if a module or extension is installed.

##Parameters:

- **value**: required
- **is_in**: required if is_not_in is not set
- **is_not_in**: required if is_in is not set
- **contains**: required if is_in or is_not_in are not set
- **separator**: optional (default: |) you can change the list separator here.

*Value*, *is_in*, *is_not_in*, *contains* parameters can be global variables, entry field value, etc.

##Examples:
	
###IS IN condition:
	{exp:pvl_checkif value="123" is_in="1|12|123"}
		<p>Yes Sir!</p>
	{else}
		<p>No Sir!</p>
	{/exp:pvl_checkif}

###IS NOT IN condition:
	
	{exp:pvl_checkif value="123" is_not_in="1|12"}
		<p>Yes Sir!</p>
	{else}
		<p>No Sir!</p>
	{/exp:pvl_checkif}

###CONTAINS condition:
	{exp:pvl_checkif value="123" contains="12"}
		<p>Yes Sir!</p>
	{else}
		<p>No Sir!</p>
	{/exp:pvl_checkif}



###Check if a module is installed:
	{exp:pvl_checkif:module is_installed="playa"}
		<p>Playa is installed</p>
	{/exp:pvl_checkif:module}

###Check if a extension is installed:
	{exp:pvl_checkif:extension is_installed="Mo_variables"}
		<p>Mo' Variables is installed</p>
	{/exp:pvl_checkif:extension}




##Release logs

###v0.6
- check if module or extension is installed
- coded refactored
- copyright updated

###v0.5
- Improved preformance by adding static cache when parsing global variables

###v0.4
- Re-parse global variables stored in config files (see bug at http://expressionengine.com/bug_tracker/bug/17801)
- Giga error when the condition is false

###v0.3
- Added "contains" parameter
- Added {else}