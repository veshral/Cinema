
<!-- 4. $MAIN_MENU =================================================================================

                        Main menu

                        Notes:
                        * to make the menu item active, add a class 'active' to the <li>
                          example: <li class="active">...</li>
                        * multilevel submenu example:
                            <li class="mm-dropdown">
                              <a href="#"><span class="mm-text">Submenu item text 1</span></a>
                              <ul>
                                <li>...</li>
                                <li class="mm-dropdown">
                                  <a href="#"><span class="mm-text">Submenu item text 2</span></a>
                                  <ul>
                                    <li>...</li>
                                    ...
                                  </ul>
                                </li>
                                ...
                              </ul>
                            </li>
-->
                <div id="main-menu" role="navigation">
                <div id="main-menu-inner">
                <div class="menu-content top" id="menu-content-demo">
                    <!-- Menu custom content demo
                         CSS:        styles/pixel-admin-less/demo.less or styles/pixel-admin-scss/_demo.scss
                         Javascript: html/assets/demo/demo.js
-->
                    <div>
                        <div class="text-bg"><span class="text-slim">Bonjour,</span> <span class="text-semibold">
                                <?php
                                $user = $this->session->userdata('user');

                                if (isset($user->username)) {
                                    echo $user->username;
                                }
                                ?>



                        </span></div>

                        <img src="

                        <?php

                            if (isset($user->avatar)) {
                                echo $user->avatar;
                            }
                            ?>

                        " alt="" class="">
                        <div class="btn-group">
                            <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-envelope"></i></a>
                            <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>
                            <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-cog"></i></a>
                            <a href="<?php echo site_url('welcome/logout'); ?>" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
                        </div>
                        <a href="#" class="close">&times;</a>
                    </div>
                </div>
                <ul class="navigation">
                    <li>
                        <a href="<?php echo site_url('welcome/index') ?>"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">Dashboard</span></a>
                    </li>

                </ul> <!-- / .navigation -->
                <div class="menu-content">
                    <a href="<?php echo site_url('movie/creer') ?>" class="btn btn-primary btn-block btn-outline dark"><i class="fa fa-plus"></i> Créer un film</a>
                </div>
                </div> <!-- / #main-menu-inner -->
                </div> <!-- / #main-menu -->
                <!-- /4. $MAIN_MENU -->