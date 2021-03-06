<?php

$app->on('cockpit.accounts.active', function ($data, $_) use ($app) {
  $settings = $app->storage->getKey('cockpit/options', 'emailonusersave.settings', []);
  
  if ( $settings['sendOnActive'] ) {
    $email = isset($settings['emailActive']) ? $settings['emailActive'] : [];

    if (!empty($email['to'])) {
      $to = $email['to'];
      $to = str_replace('[:user_mail]', $data['email'], $to);
      $subject = !empty($email['subject']) ? $email['subject'] : 'New Account';
      $body = isset($email['body']) ? $email['body'] : '';

      $vars = [
        'name' => '',
        'app' => $app,
        'body' => $body,
      ];

      $message = $app->view('emailonusersave:emails/onsave.php', $vars);

      $app->mailer->mail(
        $to,
        $subject,
        $message
      );
    }
  }
});

$app->on('cockpit.accounts.create', function ($data, $_) use ($app) {
  $settings = $app->storage->getKey('cockpit/options', 'emailonusersave.settings', []);
  
  if ($settings['emailCreate'] ) {
    $email = isset($settings['emailCreate']) ? $settings['emailCreate'] : [];

    if (!empty($email['to'])) {
      $to = $email['to'];
      $to = str_replace('[:user_mail]', $data['email'], $to);
      $subject = !empty($email['subject']) ? $email['subject'] : 'New Account saved';
      $body = isset($email['body']) ? $email['body'] : '';

      $dataHtml = "<br><p>Account data:</p><hr><br>\n";
      foreach ($data as $key => $value) {
        if ( $key != 'password' ) {
          $dataHtml .= '<div class="field">';
          $dataHtml .= "<div><b>${key}:</b></div>\n";
          if ($key === '_modified' || $key === '_created') {
            $value = date('Y-m-d H:i', $value);
          }
          if (is_string($value)) {
            $dataHtml .= "<div>${value}</div>\n";
          }
          else {
            $dataHtml .= "<pre>" . json_encode($value) . "</pre>\n";
          }
          $dataHtml .= "</div>\n";
        }
      }

      $body = str_replace('[:data]', $dataHtml, $body);

      $vars = [
        'name' => '',
        'app' => $app,
        'body' => $body,
      ];

      $message = $app->view('emailonusersave:emails/onsave.php', $vars);

      $app->mailer->mail(
        $to,
        $subject,
        $message
      );
    }
  }
});
