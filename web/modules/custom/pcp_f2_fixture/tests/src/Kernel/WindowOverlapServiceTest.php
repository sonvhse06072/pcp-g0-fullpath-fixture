<?php

namespace Drupal\Tests\pcp_f2_fixture\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\pcp_f2_fixture\WindowOverlapDetector;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

/**
 * Verifies service discovery with a real Drupal Kernel container.
 */
#[Group('pcp_f2_fixture')]
#[RunTestsInSeparateProcesses]
final class WindowOverlapServiceTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['pcp_f2_fixture'];

  /**
   * Resolves the registered detector through the Drupal service container.
   */
  public function testServiceRegistration(): void {
    $service = $this->container->get('pcp_f2_fixture.window_overlap');
    self::assertInstanceOf(WindowOverlapDetector::class, $service);
    self::assertTrue($service->intersects(540, 600, 550, 610));
    self::assertFalse($service->intersects(540, 600, 600, 660));
  }

}
