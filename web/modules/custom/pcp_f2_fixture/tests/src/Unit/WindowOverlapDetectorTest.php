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
   * Counts shared minutes for partial overlap, containment, and equality.
   */
  public function testIntersectionMinutesForOverlappingWindows(): void {
    $detector = new WindowOverlapDetector();
    self::assertSame(30, $detector->intersectionMinutes(540, 600, 570, 660));
    self::assertSame(30, $detector->intersectionMinutes(540, 660, 570, 600));
    self::assertSame(120, $detector->intersectionMinutes(540, 660, 540, 660));
  }

  /**
   * The shared-minute count is symmetric and respects day boundaries.
   */
  public function testIntersectionMinutesSymmetryAndDayBoundaries(): void {
    $detector = new WindowOverlapDetector();
    self::assertSame($detector->intersectionMinutes(570, 660, 540, 600), $detector->intersectionMinutes(540, 600, 570, 660));
    self::assertSame(10, $detector->intersectionMinutes(0, 10, 0, 20));
    self::assertSame(10, $detector->intersectionMinutes(1430, 1440, 1420, 1440));
  }

  /**
   * Touching and disjoint windows share zero minutes.
   */
  public function testIntersectionMinutesForTouchingAndDisjointWindows(): void {
    $detector = new WindowOverlapDetector();
    self::assertSame(0, $detector->intersectionMinutes(540, 600, 600, 660));
    self::assertSame(0, $detector->intersectionMinutes(540, 600, 610, 660));
  }

  /**
   * Invalid, empty, out-of-day, and overnight windows share zero minutes.
   */
  public function testIntersectionMinutesForInvalidAndOvernightWindows(): void {
    $detector = new WindowOverlapDetector();
    self::assertSame(0, $detector->intersectionMinutes(540, 540, 530, 550));
    self::assertSame(0, $detector->intersectionMinutes(-1, 10, 0, 10));
    self::assertSame(0, $detector->intersectionMinutes(0, 1441, 0, 10));
    self::assertSame(0, $detector->intersectionMinutes(1380, 60, 30, 90));
    self::assertSame(0, $detector->intersectionMinutes(0, 10, 1380, 60));
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
