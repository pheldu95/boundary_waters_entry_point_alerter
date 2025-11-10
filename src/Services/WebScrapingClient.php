<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Panther\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class WebScrapingClient
{
    private Client $client;

    public function __construct(array $options = [])
    {
        $this->client = Client::createChromeClient(null, [
            '--headless',
            '--no-sandbox',
            '--disable-dev-shm-usage',
            '--window-size=1920,1080'
        ], $options);
    }

    public function scrapeWebsite(string $url): array
    {
        try {
            $crawler = $this->client->request('GET', $url);

            //Wait for page to load
            $this->client->waitFor('title');

            //Extract basic page information
            $data = [
                'title' => $this->getPageTitle($crawler),
                'meta_description' => $this->getMetaDescription($crawler),
                'headings' => $this->getHeadings($crawler),
                'links' => $this->getLinks($crawler),
                'images' => $this->getImages($crawler)
            ];

            return $data;
        } catch (\Exception $e) {
            throw new \RuntimeException("Scraping failed: " . $e->getMessage());
        }
    }

    public function scrapeJson(string $url): array
    {
        try {
            $client = HttpClient::create();
            $response = $client->request('GET', $url);

            $statusCode = $response->getStatusCode();
            $contentType = $response->getHeaders()['content-type'][0];
            $content = $response->getContent();
            $data = $response->toArray();

            return $data;
        } catch (\Exception $e) {
            throw new \RuntimeException("Scraping JSON failed: " . $e->getMessage());
        }
    }

    private function getPageTitle(Crawler $crawler): string
    {
        return $crawler->filter('title')->count() > 0
            ? $crawler->filter('title')->text()
            : '';
    }

    private function getMetaDescription(Crawler $crawler): string
    {
        return $crawler->filter('meta[name="description"]')->count() > 0
            ? $crawler->filter('meta[name="description"]')->attr('content')
            : '';
    }

    private function getHeadings(Crawler $crawler): array
    {
        $headings = [];
        $crawler->filter('h1, h2, h3, h4, h5, h6')->each(function (Crawler $node) use (&$headings) {
            $headings[] = [
                'tag' => $node->nodeName(),
                'text' => trim($node->text())
            ];
        });
        return $headings;
    }

    private function getLinks(Crawler $crawler): array
    {
        $links = [];
        $crawler->filter('a[href]')->each(function (Crawler $node) use (&$links) {
            $href = $node->attr('href');
            if (!empty($href)) {
                $links[] = [
                    'url' => $href,
                    'text' => trim($node->text())
                ];
            }
        });
        return $links;
    }

    private function getImages(Crawler $crawler): array
    {
        $images = [];
        $crawler->filter('img[src]')->each(function (Crawler $node) use (&$images) {
            $images[] = [
                'src' => $node->attr('src'),
                'alt' => $node->attr('alt') ?? ''
            ];
        });
        return $images;
    }

    public function __destruct()
    {
        $this->client->quit();
    }
}
