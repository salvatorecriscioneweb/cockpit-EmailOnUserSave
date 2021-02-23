<?php

namespace EmailOnUserSave\Controller;

/**
 * Admin class.
 */
class Admin extends \Cockpit\AuthController {

  public function index() {
    $defaultSettings = [
      'sendOnCreate' => false,
      'sendOnActive' => false,
      'emailCreate' => [
        'to' => '[:user_mail]',
        'subject' => 'New Account Created',
        'body' => "<b>Your Account was created</b>\n\n[:data]\n\n\n<hr>\n\n<small>This is an automated email, please don't reply.</small>",
      ],
      'emailActive' => [
        'to' => '[:user_mail]',
        'subject' => 'Your account is active',
        'body' => "<b>Your Account was activated</b>\n\n\n<hr>\n\n<small>This is an automated email, please don't reply.</small>",
      ]
    ];

    $settings = $this->app->storage->getKey('cockpit/options', 'emailonusersave.settings', $defaultSettings);
    if (empty($settings)) {
      $settings = $defaultSettings;
    }

    return $this->render('emailonusersave:views/settings/index.php', [
      'settings' => $settings,
    ]);
  }

  public function saveConfig() {
    if ($data = $this->param("settings", false)) {
        $this->app->storage->setKey("cockpit/options", 'emailonusersave.settings', $data);
        return json_encode($data);
    }
    return false;
  }

}
