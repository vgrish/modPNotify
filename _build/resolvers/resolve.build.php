<?php

/** @var $modx modX */
if (!$modx = $object->xpdo AND !$object->xpdo instanceof modX) {
    return true;
}

/** @var $options */
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        $build = MODX_CORE_PATH . 'components/modpnotify/build.php';

        if (file_exists($build)) {
            @include($build);

            if (!isset($options['modules'])) {
                $options['modules'] = array_keys(array(
                    'animate'   => 0,
                    'buttons'   => 1,
                    'callbacks' => 1,
                    'confirm'   => 1,
                    'desktop'   => 0,
                    'history'   => 0,
                    'mobile'    => 0,
                    'nonblock'  => 0,
                    'reference' => 0,
                    'tooltip'   => 0
                ));
            }

            build($options['modules']);
        } else {
            $modx->log(modX::LOG_LEVEL_INFO, 'Could not be completed because a <b>build.php</b> file not found.');
        }

        break;
    case
    xPDOTransport::ACTION_UNINSTALL:
        break;
}

return true;

