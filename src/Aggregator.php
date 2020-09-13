<?php

namespace Aggregators\DaveIsMyName;

use Carbon\Carbon;
use InvalidArgumentException;
use Aggregators\Support\BaseAggregator;
use Symfony\Component\DomCrawler\Crawler;

class Aggregator extends BaseAggregator
{
    /**
     * {@inheritDoc}
     */
    public string $uri = 'https://dcblog.dev/';

    /**
     * {@inheritDoc}
     */
    public string $provider = 'Dave is my name';

    /**
     * {@inheritDoc}
     */
    public string $logo = 'logo.png';

    /**
     * {@inheritDoc}
     */
    public function articleIdentifier(): string
    {
        return 'div.flex.flex-col.rounded-lg.shadow-lg.overflow-hidden.mb-10';
    }

    /**
     * {@inheritDoc}
     */
    public function nextUrl(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('a[ref="next"]')->first()->attr('href');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function image(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('div.flex-shrink-0 > a > img')->attr('src');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function title(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('h2')->text();
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function content(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('div.text-gray-500')->text();
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function link(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('div.flex-shrink-0 > a')->attr('href');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function dateCreated(Crawler $crawler): Carbon
    {
        try {
            return Carbon::parse($crawler->filter('time')->attr('datetime'));
        } catch (InvalidArgumentException $e) {
            return Carbon::now();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function dateUpdated(Crawler $crawler): Carbon
    {
        return $this->dateCreated($crawler);
    }
}
