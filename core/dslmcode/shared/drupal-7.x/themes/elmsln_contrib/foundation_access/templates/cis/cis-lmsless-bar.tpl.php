<?php
/**
 * CIS LMS-less template file
 */
?>
<!-- Ecosystem Top Nav -->
<div id="etb-course-nav" class="row full collapse">
  <div class="columns small-12 medium-6">
    <nav class="top-bar etb-nav middle-align-wrap etb-nav--center--parent" data-options="is_hover: false" data-topbar role="navigation">
     <section>
        <!-- Left Nav Section -->
        <ul class="left kill-margin middle-align-wrap">
        <?php if ($bar_elements['network']) : ?>
          <li class="apps">
            <a href="#" class="etb-nav_item_service_btn etb-icon apps-icon middle-align-wrap" data-reveal-id="apps-nav-modal">
              <div class="icon-apps-black etb-icons svg"></div>
            </a>
          </li>
          <?php endif; ?>
          <?php if ($bar_elements['user']) : ?>
          <li>
            <a href="#" class="etb-nav_item_service_btn etb-icon user-icon middle-align-wrap" data-reveal-id="user-nav-modal">
              <div class="icon-user-black etb-icons svg"></div>
              <span class="visible-for-large-up"><?php print $username; ?></span>
            </a>
          </li>
          <?php endif; ?>
          <?php if ($bar_elements['help']) : ?>
          <li>
            <a href="#" class="etb-nav_item_service_btn etb-icon help-icon middle-align-wrap" data-reveal-id="help-nav-modal">
              <div class="icon-help-black etb-icons svg"></div>
              <span class="visible-for-large-up"><?php print t('Help'); ?></span>
            </a>
          </li>
          <?php endif; ?>
          <?php if ($bar_elements['syllabus']) : ?>
          <li class="divider-left">
            <a href="#" class="etb-nav_item_service_btn etb-icon info-icon middle-align-wrap" data-reveal-id="info-nav-modal">
              <div class="icon-info-black etb-icons svg"></div>
              <span class="visible-for-large-up"><?php print t('Syllabus'); ?></span>
            </a>
          </li>
          <?php endif; ?>
        </ul>
        <!-- Eco Nav Modals -->
        <div id="apps-nav-modal" class="reveal-modal etb-nav-modal disable-scroll" data-reveal>
            <h1><?php print $site_name; ?></h1>
              <?php if (isset($service_option_link)) : ?>
                <div class="minimal-edit-buttons in-modal">
                <a class="off-canvas-toolbar-item toolbar-menu-icon" href="#" data-dropdown="eco-services-edit-menu-1" aria-controls="offcanvas-admin-menu" aria-expanded="false">
                  <div class="icon-chevron-down-black off-canvas-toolbar-item-icon"></div>
                </a>
              </div>
              <!-- Menu Item Dropdowns -->
              <div id="eco-services-edit-menu-1" data-dropdown-content class="f-dropdown content" aria-hidden="true" tabindex="-1">
                <ul class="button-group">
                  <li><?php print l(t('Add another service'), $service_option_link); ?></li>
                  <li><?php print l(t('Edit services'), $service_option_link); ?></li>
                </ul>
              </div>
              <?php endif; ?>
              <!-- End Menu Item Dropdowns -->
              <?php foreach ($services as $title => $items) : ?>
                <hr/>
                <h2><?php print t('@title', array('@title' => $title)); ?></h2>
                <?php foreach ($items as $service) : ?>
                <a href="<?php print $service['url']; ?>" class=" etb-modal-icon <?php print $service['machine_name']; ?>-icon row">
                  <div class="icon-<?php print $service['machine_name']; ?>-black etb-modal-icons"></div>
                  <span class=""><?php print $service['title']; ?></span>
                </a>
                <?php endforeach ?>
              <?php endforeach ?>
            <a class="close-reveal-modal">&#215;</a>
         </div>
         <div id="user-nav-modal" class="reveal-modal etb-nav-modal disable-scroll" data-reveal>
            <h1><?php print t('Account'); ?></h1>
              <hr class="pad-1"></hr>
                <?php print $userlink; ?>
              <hr></hr>
              <div class="minimal-edit-buttons in-modal">
                <a class="off-canvas-toolbar-item toolbar-menu-icon" href="#" data-dropdown="eco-account-edit-menu-1" aria-controls="offcanvas-admin-menu" aria-expanded="false">
                  <div class="icon-chevron-down-black off-canvas-toolbar-item-icon"></div>
                </a>
              </div>
              <h2><?php print t('Profile'); ?></h2>
              <span><?php print $username; ?></span>
            <a class="close-reveal-modal">&#215;</a>
         </div>

         <div id="info-nav-modal" class="reveal-modal etb-nav-modal disable-scroll" data-reveal>
            <h1><?php print t('Syllabus'); ?></h1>
              <hr></hr>
              <div class="minimal-edit-buttons in-modal">
                <a class="off-canvas-toolbar-item toolbar-menu-icon" href="#" data-dropdown="eco-syllabus-edit-menu-2" aria-controls="offcanvas-admin-menu" aria-expanded="false">
                  <div class="icon-chevron-down-black off-canvas-toolbar-item-icon"></div>
                </a>
              </div>
              <!-- Menu Item Dropdowns -->
              <div id="eco-syllabus-edit-menu-2" data-dropdown-content class="f-dropdown content" aria-hidden="true" tabindex="-1">
                <ul class="button-group">
                  <li><a href="#" data-reveal-id="block-cis-service-connection-section-context-changer-nav-modal">View another section</a></li>
                  <li><?php print l(t('Download Syllabus'),'syllabus/download'); ?></li>
                </ul>
              </div>
              <!-- End Menu Item Dropdowns -->
              <h2><?php print t('Section'); ?> (<span class="section-id"><?php print $section; ?></span>)</h2>
              <?php if (!empty($main_menu)) : print drupal_render($main_menu); endif; ?>
            <a class="close-reveal-modal">&#215;</a>
         </div>

         <div id="help-nav-modal" class="reveal-modal etb-nav-modal disable-scroll" data-reveal>
            <h1><?php print t('Help'); ?></h1>
              <hr></hr>
              <div class="minimal-edit-buttons in-modal">
                <a class="off-canvas-toolbar-item toolbar-menu-icon" href="#" data-dropdown="eco-help-edit-menu-1" aria-controls="offcanvas-admin-menu" aria-expanded="false">
                  <div class="icon-chevron-down-black off-canvas-toolbar-item-icon"></div>
                </a>
              </div>
              <!-- Menu Item Dropdowns -->
              <div id="eco-help-edit-menu-1" data-dropdown-content class="f-dropdown content" aria-hidden="true" tabindex="-1">
                <ul class="button-group">
                  <li><a href="#"><?php print t('Edit contact'); ?></a></li>
                </ul>
              </div>
              <!-- End Menu Item Dropdowns -->
              <h2 class"etb-nav-section-label"><?php print t('Contact'); ?></h2>
              <?php print $contact_block; ?>
              <?php if (isset($tech_support['body'])) : ?>
                <h2 class"etb-nav-section-label"><?php print $tech_support['title']; ?></h2>
                <?php print $tech_support['body']; ?>
              <?php endif; ?>
              <!--<a href="#" class="etb-modal-icon teacher-icon row">
                <div class="icon-teacher-black etb-modal-icons"></div>
                <span><?php print t('E-Mail your instructor'); ?></span>
              </a>-->
              <hr></hr>
              <h2 class"etb-nav-section-label"><?php print t('Technical Issues'); ?></h2>
              <a href="<?php print $help_link; ?>" class="etb-nav_item_service_btn etb-modal-icon support-icon row">
                <div class="icon-support-black etb-modal-icons"></div>
                <span><?php print t('Help page');?></span>
              </a>
              <a href="<?php print $tour; ?>" class="etb-nav_item_service_btn etb-modal-icon tour-icon row">
                <div class="icon-tour-black etb-modal-icons"></div>
                <span><?php print t('Take a tour'); ?></span>
              </a>
            <a class="close-reveal-modal">&#215;</a>
         </div>
        </section>
      </nav>
    </div>
    <div class="etb-title small-12 medium-6 columns">
      <nav class="top-bar etb-nav flex-vertical-right center-align-wrap" data-options="is_hover: false" data-topbar role="navigation">
       <section class="top-bar-section title-link">
          <ul class="right">
            <li>
              <?php print l('<span class="course-title">' . $slogan . '</span><span class="course-abrv">' . $site_name . '</span></a>', '<front>', array('html' => TRUE)); ?>
            </li>
          </ul>
        </section>
      </nav>
    </div>
  </div>
