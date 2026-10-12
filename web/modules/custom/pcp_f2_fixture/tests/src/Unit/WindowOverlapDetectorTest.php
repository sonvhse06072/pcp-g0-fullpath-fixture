<?php

namespace Drupal\Tests\pcp_f2_fixture\Unit;

use Drupal\pcp_f2_fixture\WindowOverlapDetector;
use Drupal\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\Group;

/**
 * Tests the independent baseline time-window overlap behavior.
 *
 * @coversDefaultClass \Drupal\pcp_f2_fixture\WindowOverlapDetector
 */
#[Group('pcp_f2_fixture')]
final class WindowOverlapDetectorTest extends UnitTestCase {

  /**
   * A partly shared same-day interval counts as an overlap.
   */
  public function testPartlyOverlappingWindows(): void {
    $detector = new WindowOverlapDetector();
    self::assertTrue($detector->intersects(540, 600, 570, 660));
    self::assertTrue($detector->intersects(570, 660, 540, 600));
  }

  /**
   * An adjacent endpoint is excluded by half-open boundaries.
   */
  public function testTouchingWindowsDoNotOverlap(): void {
    self::assertFalse((new WindowOverlapDetector())->intersects(540, 600, 600, 660));
  }

  /**
   * Empty and out-of-day intervals fail closed.
   */
  public function testInvalidWindowsFailClosed(): void {
    $detector = new WindowOverlapDetector();
    self::assertFalse($detector->intersects(540, 540, 570, 660));
    self::assertFalse($detector->intersects(-1, 10, 10, 30));
    self::assertFalse($detector->intersects(0, 1441, 100, 200));
  }

  /**
   * Overnight handling is reserved for F2-T01 and not present in this seed.
   */
  public function testOvernightWindowsAreNotYetSupported(): void {
    self::assertFalse((new WindowOverlapDetector())->intersects(1380, 60, 30, 90));
  }

}
