# Cockpit-EmailOnUserSave

Extend Cockpit core functionality by sending a customized email when an user is saved or activated.

## Installation

1. Confirm that you have cockpit configured to send emails
2. Download zip and extract directory 'EmailOnUserSave' to 'your-cockpit-docroot/addons' ( Addon directory should name EmailOnUserSave, now you'll have your-cockpit-docroot/addons/EmailOnUserSave/bootstrap.php )
3. If directory is lowercase( emailonusersave ), rename to 'EmailOnUserSave' camelcase.
4. Access module settings (http://your-cockpit-site/emailonusersave) and confirm that configuration page is loaded

## Configuration

On the configuration page there are 2 main sections, the first, on the left, will provide email specific configurations:

* Email To email value (one email or multiple emails separated by comma)
* Email Subject text
* Email Body template, a token string ([:data]) can be used to include the collection data

On the right, there is a list with all available collections, enabling a specific collection will trigger the email every time the collection is saved.

* Missing Screenshot *

Using the default template, an email will render as below:

* Missing Screenshot *

## Copyright and license

Copyright 2018 pauloamgomes under the MIT license.

Edited by salvatorecriscioneweb 2021 accordingly the MIT license.
