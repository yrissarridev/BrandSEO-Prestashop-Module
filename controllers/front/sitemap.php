<?php

class BrandseoSitemapModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        header('Content-Type: application/xml; charset=utf-8');

        $base = $this->context->link->getBaseLink();

        $rows = Db::getInstance()->executeS('
            SELECT slug, date_upd
            FROM `'._DB_PREFIX_.'brandseo_landing`
            WHERE status = "published"
            AND active = 1
            AND noindex = 0
            ORDER BY date_upd DESC
        ');

        echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($rows as $row) {
            echo "  <url>\n";
            echo '    <loc>'.htmlspecialchars($base.'marcas/'.$row['slug'], ENT_XML1, 'UTF-8')."</loc>\n";
            echo '    <lastmod>'.date('Y-m-d', strtotime($row['date_upd']))."</lastmod>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.8</priority>\n";
            echo "  </url>\n";
        }

        echo "</urlset>\n";
        exit;
    }
}
