<?php

/**
 * @file
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * Use render($user_profile) to print all profile items, or print a subset
 * such as render($user_profile['user_picture']). Always call
 * render($user_profile) at the end in order to print all remaining items. If
 * the item is a category, it will contain all its profile items. By default,
 * $user_profile['summary'] is provided, which contains data on the user's
 * history. Other data can be included by modules. $user_profile['user_picture']
 * is available for showing the account picture.
 *
 * Available variables:
 *   - $user_profile: An array of profile items. Use render() to print them.
 *   - Field variables: for each field instance attached to the user a
 *     corresponding variable is defined; e.g., $account->field_example has a
 *     variable $field_example defined. When needing to access a field's raw
 *     values, developers/themers are strongly encouraged to use these
 *     variables. Otherwise they will have to explicitly specify the desired
 *     field language, e.g. $account->field_example['en'], thus overriding any
 *     language negotiation rule that was previously applied.
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-item.tpl.php
 *   Where the html is handled for each item in the group.
 * @see template_preprocess_user_profile()
 *
 * @ingroup themeable
 */
?>
<div class="profile row"<?php //print $attributes; ?>>
  <div class="col-md-6 col-sm-12">
    <?php
    $unread_pm = privatemsg_unread_count($variables['user']->uid);
    ($unread_pm > 0) ? $new_messages = true: $new_messages = false;
    ($new_messages) ? $unread_count = ' (' . '$unread_pm' . ')' : $unread_count = ' (0)';
    $msg_anchor_text = t('Messages') . $unread_count;
    print '<div>' . l(t('Ordinary orders list'),'user/' . $user->uid . '/orders', array('attributes' => array('class' => array('btn', 'btn-primary')), 'html' => true))
         .'</div>';
    print '<div>' . l(t('Sewing orders list'), 'user/' . $user->uid . '/sewing', ['html' => TRUE]) . '</div>';
    print '<div>' . l($msg_anchor_text, 'user/' . $user->uid . '/orders', array('html' => true)) .'</div>';
    ?>
  </div>
  <div class="col-md-6 col-sm-12">
    <?php $mc_currency = mc_currency_load('rmb');
    $mc_currency = $mc_currency->info['currcode'];
    $uid = $user->uid;
    $mc_balance = transaction_totals($uid, $mc_currency);
    $default_currency_code = variable_get('uc_currency_code', UC_CURRENCY_DEFAULT_CURRENCY);
    $code = isset($_SESSION['currency_switcher']) ? $_SESSION['currency_switcher'] : $default_currency_code;
    $symbol = currency_api_get_symbol($code); ?>
    <span class="header-user-wallet"><?php $anchor_text = t('Your balance') . ': ' . $mc_balance->balance . '元'; print l($anchor_text, '/user/' . $user->uid . '/wallet', array('html' => TRUE));
    print '<div class="profile-summary-item">' . t('Your account manager is ') .
      '<a href="/contact">' . render($user_profile['summary']['field_manager'][0]['#item']['entity']->title) .
      '</a></div>' .
      '<div>' . l(t('Edit profile'), 'user/' . $user->uid . '/edit', array('html' => true)) .'</div>';?>
  </div>
</div>
