<?php

// ACL.
$this("acl")->addResource('EmailOnUserSave', ['manage.emailonusersave']);

/*
 * add menu entry if the user has access to group stuff
 */
$this->on('cockpit.view.settings.item', function () {
  if ($this->module('cockpit')->hasaccess('EmailOnUserSave', 'manage.emailonusersave')) {
    $this->renderView("emailonusersave:views/partials/settings.php");
  }
});

$app->on('admin.init', function () use ($app) {
  // Bind admin routes /emailonusersave.
  $this->bindClass('EmailOnUserSave\\Controller\\Admin', 'emailonusersave');
});
