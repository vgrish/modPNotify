<?php

function build($modules)
{
    global $modx;

    if (empty($modules)) {
        $modules = array(
            'buttons',
            'confirm',
            'callbacks',
        );
    }

    $pnotifyPath = MODX_CORE_PATH . 'components/modpnotify/build/';
    if (!file_exists($pnotifyPath . '.download')) {
        $modx->log(modX::LOG_LEVEL_INFO, 'Could not build <b>PNotify</b> files.');

        return '';
    }

    $pnotifyPath .= 'pnotify-master/';
    $min = '';


    sort($modules);

    $modx->log(modX::LOG_LEVEL_INFO, '<b>PNotify</b> modules - ' . implode(', ', $modules));

    foreach (array('css', 'js') as $ext) {
        $content = '';
        if ($min === '') {
            $content = "/* PNotify modules included in this custom build file:\n" .
                implode("\n", $modules) .
                "\n*/\n";
        }

        $content .= file_get_contents("{$pnotifyPath}src/pnotify.$ext");
        foreach ($modules as $cur) {
            $filename = "src/pnotify.{$cur}.{$min}{$ext}";
            if (!file_exists($pnotifyPath . $filename)) {
                $other = "src/pnotify.{$cur}.{$min}" . ($ext === "css" ? "js" : "css");
                if (file_exists($pnotifyPath . $other)) {
                    continue;
                }
                $modx->log(modX::LOG_LEVEL_INFO, 'Could not be completed because a file is invalid ' . $other);

                return false;
            }
            $content .= file_get_contents($pnotifyPath . $filename);
        }

        $filename = 'pnotify.custom.' . $min . $ext;

        if (!file_put_contents(MODX_ASSETS_PATH . 'components/modpnotify/build/' . $filename, $content)) {
            $modx->log(modX::LOG_LEVEL_INFO, "Could not save custom file - <b>$filename</b>");
        }

        $modx->log(modX::LOG_LEVEL_INFO, "Success - <b>$filename</b>");
    }

}

