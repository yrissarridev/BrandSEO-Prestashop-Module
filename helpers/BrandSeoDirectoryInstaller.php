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

        // Protect upload directories that accept user-supplied files from PHP execution.
        $htaccessContent = <<<'HTACCESS'
# Deny execution of PHP and other server-side script files
<FilesMatch "\.(php|php3|php4|php5|php6|php7|php8|phtml|phar|cgi|pl|py|sh|asp|aspx|jsp)$">
    Require all denied
</FilesMatch>
Options -ExecCGI -Indexes
<IfModule mod_php.c>
    php_flag engine off
</IfModule>
<IfModule mod_php5.c>
    php_flag engine off
</IfModule>
<IfModule mod_php7.c>
    php_flag engine off
</IfModule>
<IfModule mod_php8.c>
    php_flag engine off
</IfModule>
HTACCESS;

        $uploadSubdirs = array('uploads/hero', 'uploads/gallery', 'uploads/tmp');
        foreach ($uploadSubdirs as $uploadDir) {
            $htaccessPath = rtrim($modulePath, '/').'/'.$uploadDir.'/.htaccess';
            if (!file_exists($htaccessPath)) {
                file_put_contents($htaccessPath, $htaccessContent);
            }
        }

        return true;
    }
}
