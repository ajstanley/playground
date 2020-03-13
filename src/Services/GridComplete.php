<?php
/**
 * Created by PhpStorm.
 * User: alanstanley
 * Date: 2019-05-27
 * Time: 10:43
 */

namespace Drupal\playground\Services;



class GridComplete {
    private $client;

    public function __construct($client) {
        $this->client = $client;

    }

    public function getQueryResults($query) {
        $uri = 'https://www.grid.ac/institutes';
        $response = $this->client->request('GET', $uri,
            [
                'form_params' => [
                    'utf8' => '✓',
                    'search[query]' => $query
                ],
            ]);
        $html = $response->getBody()->getContents();
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $nodes  = $xpath->query('.//div[@class="search-result"]');
        foreach ($nodes as $node) {
            $text = trim($node->textContent);
            $contents = $output = preg_replace('"(\r?\n){2,}"', "\n", $text);
            $parts = explode("\n", $contents);


        }


        $results = json_decode($json);
        return $results->results->bindings;
    }


}
