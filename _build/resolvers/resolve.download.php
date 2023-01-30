<?php

if (!function_exists('download')) {
    function download($src, $dst)
    {
        if (ini_get('allow_url_fopen')) {
            $file = @file_get_contents($src);
        } else {
            if (function_exists('curl_init')) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $src);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 180);
                $safeMode = @ini_get('safe_mode');
                $openBasedir = @ini_get('open_basedir');
                if (empty($safeMode) && empty($openBasedir)) {
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                }
                $file = curl_exec($ch);
                curl_close($ch);
            } else {
                return false;
            }
        }
        file_put_contents($dst, $file);

        return file_exists($dst);
    }
}

/** @var $modx modX */
if (!$modx = $object->xpdo AND !$object->xpdo instanceof modX) {
    return true;
}

/** @var $options */
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        if (!class_exists('PclZip')) {
            require MODX_CORE_PATH . 'xpdo/compression/pclzip.lib.php';
        }

        $pnotifySource = 'https://github.com/sciactive/pnotify/archive/refs/heads/v3.zip';
        $pnotifyPath = MODX_CORE_PATH . 'components/modpnotify/build/';
        $pnotifyZip = $pnotifyPath . 'pnotify-3.zip';

        if (file_exists($pnotifyPath . '.download') AND $cacheManager = $modx->getCacheManager()) {
            $modx->log(modX::LOG_LEVEL_INFO, 'Trying to delete old <b>PNotify</b> files. Please wait...');
            $cacheManager->deleteTree($pnotifyPath,
                array_merge(array('deleteTop' => false, 'skipDirs' => false, 'extensions' => array())));
        }

        $modx->log(modX::LOG_LEVEL_INFO, 'Trying to download <b>PNotify</b>. Please wait...');
        download($pnotifySource, $pnotifyZip);

        $file = new PclZip($pnotifyZip);
        if ($pnotify = $file->extract(PCLZIP_OPT_PATH, $pnotifyPath)) {
            unlink($pnotifyZip);
            file_put_contents($pnotifyPath . '.download', date('Y-m-d H:i:s'));
        } else {
            $modx->log(xPDO::LOG_LEVEL_ERROR,
                'Could not extract PNotify from ' . $pnotifyZip . ' to ' . $pnotifyPath . '. Error: ' . $file->errorInfo());

            return false;
        }

        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return true;