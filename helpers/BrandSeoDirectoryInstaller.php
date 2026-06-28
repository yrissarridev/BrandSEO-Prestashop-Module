<?php

class BrandSeoDirectoryInstaller
{
    public static function install($modulePath)
    {
        $directories = array(
            'uploads',
            'uploads/hero',
            'uploads/gallery',
            'uploads/tmp',
        );

        foreach ($directories as $directory) {
            $path = rtrim($modulePath, '/').'/'.$directory;

            if (!is_dir($path) && !mkdir($path, 0755, true)) {
                return false;
            }

            $indexFile = $path.'/index.php';

            if (!file_exists($indexFile)) {
                file_put_contents($indexFile, "<?php\n// Silence is golden.\n");
            }
        }

        return true;
    }
}
