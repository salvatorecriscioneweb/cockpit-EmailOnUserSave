# Cockpit-EmailOnUserSave

Extend Cockpit core functionality by sending a customized email when an user is saved or activated.

## Installation

1. Confirm that you have cockpit configured to send emails
2. Download zip and extract directory 'EmailOnUserSave' to 'your-cockpit-docroot/addons' ( Addon directory should name EmailOnUserSave, now you'll have your-cockpit-docroot/addons/EmailOnUserSave/bootstrap.php )
3. If directory is lowercase( emailonusersave ), rename to 'EmailOnUserSave' camelcase.
4. Access module settings (http://your-cockpit-site/emailonusersave) and confirm that configuration page is loaded

## Requirements:

Due lacks of events ( triggers ) by official cockpit, you need the patched Accounts that have 'cockpit.accounts.active' and 'cockpit.accounts.create' triggers.

[modules/Cockpit/Controller/Accounts.php (patched)](https://github.com/salvatorecriscioneweb/cockpit-useful-scripts-addons/blob/main/trigger-on-user-active/Accounts.php)

or you can patch by yourself file `modules/Cockpit/Controller/Accounts.php`

add these lines just before `$this->app->storage->save('cockpit/accounts', $data);`

```

if (isset($data['active'])) {
    $_account = $this->app->storage->findOne('cockpit/accounts', ['email'  => $data['email']]);

    if ($_account && $_account['active'] != $data['active'] && $data['active']) {
        $this->app->trigger('cockpit.accounts.active', [&$data, isset($data['_id'])]);
    }
            
}

if ($data['_created'] == $data['_modified']) {
    $this->app->trigger('cockpit.accounts.create', [&$data, isset($data['_id'])]);
}

```

## Screenshot

![Setting](https://raw.githubusercontent.com/salvatorecriscioneweb/cockpit-EmailOnUserSave/master/screenshot/SaveOnUser.PNG)

## Configuration

On the configuration page there are 2 main sections, the first, on the left, will provide email specific configurations:

* Email To email value (one email or multiple emails separated by comma, can self targetting user)
* Email Subject text
* Email Body template, a token string ([:data]) can be used to include the collection data


## Copyright and license

Copyright 2021 salvatorecriscioneweb accordingly the MIT license.
