<?php

declare(strict_types=1);

namespace Tests\Fakers\Company;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Company\JobTitleFaker;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class JobTitleFakerTest extends TestCase
{
    private $loader;

    private array $jobTitles = ['CEO', 'Web Designer', 'backend developer', 'Project Manager', 'product owner'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->jobTitles);
    }

    #[Test]
    public function it_returns_fake_job_title(): void
    {
        $faker = new JobTitleFaker($this->loader);
        $jobTitle = $faker->generate();

        $this->assertIsString($jobTitle);
        $this->assertContains($jobTitle, $this->jobTitles);
    }
}
