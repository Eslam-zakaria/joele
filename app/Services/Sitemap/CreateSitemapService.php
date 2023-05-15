<?php

namespace App\Services\Sitemap;


use DOMAttr;
use DOMDocument;

class CreateSitemapService
{
    /**
     * Create sitmap;
     *
     * @return bool
     * @throws \DOMException
     */
    public function create()
    {
        # services collect sitemap data.
        $data = app(GetSitemapDataService::class)->collect();

        # Generate sitemap file.
        $this->setSitemapFile($data);

        return true;
    }

    /**
     * Generate file map file.
     *
     * @param array $data
     * @return void
     * @throws \DOMException
     */
    public function setSitemapFile(array $data)
    {
        $dom = new DOMDocument();

        $dom->encoding = 'utf-8';

        $dom->xmlVersion = '1.0';

        $dom->formatOutput = true;

        $xml_file_name = 'sitemap.xml';

        $main = $dom->createElement('urlset');
        $main_xmlns = new DOMAttr('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $main->setAttributeNode($main_xmlns);

        foreach ($data as $row){

            $child_main = $dom->createElement('url');

            if( $row['type'] == 'page' ){

                $child_main_loc = $dom->createElement('loc', $row['url']);
                $child_main->appendChild($child_main_loc);

                $child_main_lastmod = $dom->createElement('lastmod', $row['lastmod']);
                $child_main->appendChild($child_main_lastmod);

                $child_main_priority = $dom->createElement('priority', $row['priority']);
                $child_main->appendChild($child_main_priority);

            } else{

                $child_main_loc = $dom->createElement('loc', $row['url']);
                $child_main->appendChild($child_main_loc);

                $new_main = $dom->createElement('news:news');
                $child_main->appendChild($new_main);

                # BEGIN :: Publication data.
                $main_publication = $dom->createElement('news:publication');
                $new_main->appendChild($main_publication);

                $publication_name = $dom->createElement('news:name',  $row['title']);
                $main_publication->appendChild($publication_name);

                $publication_name = $dom->createElement('news:language',  $row['lang']);
                $main_publication->appendChild($publication_name);
                # END :: Publication data.

                $new_publication_date = $dom->createElement('news:publication_date',  $row['date']);
                $new_main->appendChild($new_publication_date);

                $news_publication_title = $dom->createElement('news:title',  $row['title']);
                $new_main->appendChild($news_publication_title);
            }

            $main->appendChild($child_main);
        }

        $dom->appendChild($main);
        $dom->save($xml_file_name);
    }
}
