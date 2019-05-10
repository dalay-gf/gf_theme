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
  $uid = $user->uid;
  $unread_pm = privatemsg_unread_count($variables['user']->uid);
  ($unread_pm > 0) ? $new_messages = true: $new_messages = false;
  ($new_messages) ? $unread_count = ' (' . '$unread_pm' . ')' : $unread_count = ' (0)';
  $msg_anchor_text = t('Messages') . $unread_count;
  $manager = render($user_profile['summary']['field_manager'][0]['#item']['entity']->title);
  if (empty($manager)) $manager = t('Not assigned');
?>
<div class="profile container">
  <div class="columns">
    <div class="column col-6 col-md-12 wallet">
      <?php print l(t('Ordinary orders list'),'user/' . $user->uid . '/orders', array('attributes' => array('class' => array('btn', 'btn-primary')), 'html' => true)); ?>     
    </div>
    <div class="column col-6 col-md-12 wallet">
      <div class="profile-manager">
        <span><?php print t('Your account manager is '); ?></span>
        <a href="/contact"><?php print $manager; ?></a>
      </div>
    </div>
  </div>
  <div class="columns">
    <div class="column col-12 col-sm-12">
      <?php
        print l($msg_anchor_text, 'user/' . $user->uid . '/messages', array('attributes' => array('class' => array('btn', 'btn-primary')), 'html' => true));
        print l(t('Edit profile'), 'user/' . $user->uid . '/edit', array('attributes' => array('class' => array('btn', 'btn-primary')), 'html' => true));
      ?>
    </div>
</div>
