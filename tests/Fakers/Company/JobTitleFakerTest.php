<?php

declare(strict_types=1);

namespace Tests\Fakers\Company;

use AliYavari\PersianFaker\Fakers\Company\JobTitleFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Mockery;
use Tests\TestCase;

class JobTitleFakerTest extends TestCase
{
    protected $loader;

    protected array $jobTitles = ['CEO', 'Web Designer', 'backend developer', 'Project Manager', 'product owner'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoader::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->jobTitles);
    }

    public function test_it_returns_fake_job_title(): void
    {
        $faker = new JobTitleFaker($this->loader);
        $jobTitle = $faker->generate();

        $this->assertIsString($jobTitle);
        $this->assertContains($jobTitle, $this->jobTitles);
    }
}
