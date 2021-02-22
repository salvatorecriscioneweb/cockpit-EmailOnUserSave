<?php

namespace EmailOnUserSave\Controller;

/**
 * Admin class.
 */
class Admin extends \Cockpit\AuthController {

  public function index() {
    $collections = $this->module('collections')->getCollectionsInGroup();
    $defaultSettings = [
      'collections' => [],
      'email' => [
        'to' => '',
        'subject' => 'Collection saved',
        'body' => "<b>New collection saved</b>\n\n[:data]\n\n\n<hr>\n\n<small>This is an automated email, please don't reply.</small>",
      ],
    ];

    $settings = $this->app->storage->getKey('cockpit/options', 'emailonusersave.settings', $defaultSettings);
    if (empty($settings)) {
      $settings = $defaultSettings;
    }

    return $this->render('emailonusersave:views/settings/index.php', [
      'collections' => $collections,
      'settings' => $settings,
    ]);
  }

  public function save() {
    if ($data = $this->param("settings", false)) {
        $this->app->storage->setKey("cockpit/options", 'emailonusersave.settings', $data);
        return json_encode($data);
    }
    return [];
  }

}
