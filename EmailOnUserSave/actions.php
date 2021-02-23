<?php

$app->on('cockpit.accounts.active', function ($name, $data) use ($app) {
  $settings = $app->storage->getKey('cockpit/options', 'emailonusersave.settings', []);
  
  if ( $settings['sendOnActive'] ) {
    $email = isset($settings['emailActive']) ? $settings['emailActive'] : [];

    if (!empty($email['to'])) {
      $to = $email['to'];
      $to = str_replace('[:user_mail]', $name['email'], $to);
      $subject = !empty($email['subject']) ? $email['subject'] : 'New collection saved';
      $body = isset($email['body']) ? $email['body'] : '';

      $dataHtml = "<br><hr><br>\n";
      foreach ($data as $key => $value) {
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

      $body = str_replace('[:data]', $dataHtml, $body);

      $vars = [
        'name' => $name,
        'app' => $app,
        'body' => $body,
      ];

      $message = $app->view('emailonusersave:emails/onsave.php', $vars);

      $app->mailer->mail(
        $email['to'],
        $subject,
        $message
      );
    }
  }
});

$app->on('cockpit.accounts.create', function ($name, $data) use ($app) {
  $settings = $app->storage->getKey('cockpit/options', 'emailonusersave.settings', []);
  
  if ($settings['emailCreate'] ) {
    $email = isset($settings['emailCreate']) ? $settings['emailCreate'] : [];

    if (!empty($email['to'])) {
      $to = $email['to']
      $to = str_replace('[:user_mail]', $name['email'], $to);
      $subject = !empty($email['subject']) ? $email['subject'] : 'New collection saved';
      $body = isset($email['body']) ? $email['body'] : '';

      $dataHtml = "<br><hr><br>\n";
      foreach ($data as $key => $value) {
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

      $body = str_replace('[:data]', $dataHtml, $body);

      $vars = [
        'name' => $name,
        'app' => $app,
        'body' => $body,
      ];

      $message = $app->view('emailonusersave:emails/onsave.php', $vars);

      $app->mailer->mail(
        $email['to'],
        $subject,
        $message
      );
    }
  }
});
