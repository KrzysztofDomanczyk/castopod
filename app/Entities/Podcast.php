<?php

/**
 * @copyright  2020 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace App\Entities;

use App\Models\CategoryModel;
use App\Models\EpisodeModel;
use App\Models\PlatformModel;
use CodeIgniter\Entity;
use App\Models\UserModel;
use League\CommonMark\CommonMarkConverter;

class Podcast extends Entity
{
    /**
     * @var string
     */
    protected $link;

    /**
     * @var \App\Entities\Image
     */
    protected $image;

    /**
     * @var \App\Entities\Episode[]
     */
    protected $episodes;

    /**
     * @var \App\Entities\Category
     */
    protected $category;

    /**
     * @var \App\Entities\Category[]
     */
    protected $other_categories;

    /**
     * @var integer[]
     */
    protected $other_categories_ids;

    /**
     * @var \App\Entities\User[]
     */
    protected $contributors;

    /**
     * @var \App\Entities\Platform
     */
    protected $podcastingPlatforms;

    /**
     * @var \App\Entities\Platform
     */
    protected $socialPlatforms;

    /**
     * @var \App\Entities\Platform
     */
    protected $fundingPlatforms;

    /**
     * Holds text only description, striped of any markdown or html special characters
     *
     * @var string
     */
    protected $description;

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'name' => 'string',
        'description_markdown' => 'string',
        'description_html' => 'string',
        'image_uri' => 'string',
        'language_code' => 'string',
        'category_id' => 'integer',
        'parental_advisory' => '?string',
        'publisher' => '?string',
        'owner_name' => 'string',
        'owner_email' => 'string',
        'type' => 'string',
        'copyright' => '?string',
        'episode_description_footer_markdown' => '?string',
        'episode_description_footer_html' => '?string',
        'is_blocked' => 'boolean',
        'is_completed' => 'boolean',
        'is_locked' => 'boolean',
        'imported_feed_url' => '?string',
        'new_feed_url' => '?string',
        'payment_pointer' => '?string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * Saves a cover image to the corresponding podcast folder in `public/media/podcast_name/`
     *
     * @param \CodeIgniter\HTTP\Files\UploadedFile|\CodeIgniter\Files\File $image
     *
     */
    public function setImage($image = null)
    {
        if ($image) {
            helper('media');

            $this->attributes['image_uri'] = save_podcast_media(
                $image,
                $this->attributes['name'],
                'cover'
            );
            $this->image = new \App\Entities\Image(
                $this->attributes['image_uri']
            );
            $this->image->saveSizes();
        }

        return $this;
    }

    public function getImage()
    {
        return new \App\Entities\Image($this->attributes['image_uri']);
    }

    public function getLink()
    {
        return base_url(route_to('podcast', $this->attributes['name']));
    }

    public function getFeedUrl()
    {
        return base_url(route_to('podcast_feed', $this->attributes['name']));
    }

    /**
     * Returns the podcast's episodes
     *
     * @return \App\Entities\Episode[]
     */
    public function getEpisodes()
    {
        if (empty($this->id)) {
            throw new \RuntimeException(
                'Podcast must be created before getting episodes.'
            );
        }

        if (empty($this->episodes)) {
            $this->episodes = (new EpisodeModel())->getPodcastEpisodes(
                $this->id,
                $this->type
            );
        }

        return $this->episodes;
    }

    /**
     * Returns the podcast category entity
     *
     * @return \App\Entities\Category
     */
    public function getCategory()
    {
        if (empty($this->id)) {
            throw new \RuntimeException(
                'Podcast must be created before getting category.'
            );
        }

        if (empty($this->category)) {
            $this->category = (new CategoryModel())->find($this->category_id);
        }

        return $this->category;
    }

    /**
     * Returns all podcast contributors
     *
     * @return \App\Entities\User[]
     */
    public function getContributors()
    {
        if (empty($this->id)) {
            throw new \RuntimeException(
                'Podcasts must be created before getting contributors.'
            );
        }

        if (empty($this->contributors)) {
            $this->contributors = (new UserModel())->getPodcastContributors(
                $this->id
            );
        }

        return $this->contributors;
    }

    public function setDescriptionMarkdown(string $descriptionMarkdown)
    {
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $this->attributes['description_markdown'] = $descriptionMarkdown;
        $this->attributes['description_html'] = $converter->convertToHtml(
            $descriptionMarkdown
        );

        return $this;
    }

    public function setEpisodeDescriptionFooterMarkdown(
        string $episodeDescriptionFooterMarkdown = null
    ) {
        if ($episodeDescriptionFooterMarkdown) {
            $converter = new CommonMarkConverter([
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
            ]);

            $this->attributes[
                'episode_description_footer_markdown'
            ] = $episodeDescriptionFooterMarkdown;
            $this->attributes[
                'episode_description_footer_html'
            ] = $converter->convertToHtml($episodeDescriptionFooterMarkdown);
        }

        return $this;
    }

    public function getDescription()
    {
        if ($this->description) {
            return $this->description;
        }

        return trim(
            preg_replace(
                '/\s+/',
                ' ',
                strip_tags($this->attributes['description_html'])
            )
        );
    }

    public function setCreatedBy(\App\Entities\User $user)
    {
        $this->attributes['created_by'] = $user->id;

        return $this;
    }

    public function setUpdatedBy(\App\Entities\User $user)
    {
        $this->attributes['updated_by'] = $user->id;

        return $this;
    }

    /**
     * Returns the podcast's podcasting platform links
     *
     * @return \App\Entities\Platform[]
     */
    public function getPodcastingPlatforms()
    {
        if (empty($this->id)) {
            throw new \RuntimeException(
                'Podcast must be created before getting podcasting platform links.'
            );
        }

        if (empty($this->podcastingPlatforms)) {
            $this->podcastingPlatforms = (new PlatformModel())->getPodcastPlatforms(
                $this->id,
                'podcasting'
            );
        }

        return $this->podcastingPlatforms;
    }

    /**
     * Returns the podcast's social platform links
     *
     * @return \App\Entities\Platform[]
     */
    public function getSocialPlatforms()
    {
        if (empty($this->id)) {
            throw new \RuntimeException(
                'Podcast must be created before getting social platform links.'
            );
        }

        if (empty($this->socialPlatforms)) {
            $this->socialPlatforms = (new PlatformModel())->getPodcastPlatforms(
                $this->id,
                'social'
            );
        }

        return $this->socialPlatforms;
    }

    /**
     * Returns the podcast's funding platform links
     *
     * @return \App\Entities\Platform[]
     */
    public function getFundingPlatforms()
    {
        if (empty($this->id)) {
            throw new \RuntimeException(
                'Podcast must be created before getting funding platform links.'
            );
        }

        if (empty($this->fundingPlatforms)) {
            $this->fundingPlatforms = (new PlatformModel())->getPodcastPlatforms(
                $this->id,
                'funding'
            );
        }

        return $this->fundingPlatforms;
    }

    public function getOtherCategories()
    {
        if (empty($this->id)) {
            throw new \RuntimeException(
                'Podcast must be created before getting other categories.'
            );
        }

        if (empty($this->other_categories)) {
            $this->other_categories = (new CategoryModel())->getPodcastCategories(
                $this->id
            );
        }

        return $this->other_categories;
    }

    public function getOtherCategoriesIds()
    {
        if (empty($this->other_categories_ids)) {
            $this->other_categories_ids = array_column(
                $this->getOtherCategories(),
                'id'
            );
        }

        return $this->other_categories_ids;
    }
}
