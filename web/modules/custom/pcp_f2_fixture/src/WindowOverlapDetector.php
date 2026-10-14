<?php

namespace Drupal\pcp_f2_fixture;

/**
 * Detects collisions between half-open time windows on a 24-hour clock.
 */
final class WindowOverlapDetector {

  /**
   * Returns TRUE if two valid windows share at least one minute.
   *
   * Touching endpoints do not overlap: [540, 600) and [600, 660) are separate.
   * Starts are in [0, 1439], and ends are in [0, 1440]. An end before its
   * start wraps to the next day.
   */
  public function intersects(int $start, int $end, int $otherStart, int $otherEnd): bool {
    if (!$this->isValidWindow($start, $end) || !$this->isValidWindow($otherStart, $otherEnd)) {
      return FALSE;
    }

    foreach ($this->segments($start, $end) as [$segmentStart, $segmentEnd]) {
      foreach ($this->segments($otherStart, $otherEnd) as [$otherSegmentStart, $otherSegmentEnd]) {
        if ($segmentStart < $otherSegmentEnd && $otherSegmentStart < $segmentEnd) {
          return TRUE;
        }
      }
    }

    return FALSE;
  }

  /**
   * Checks the endpoint ranges and rejects empty windows.
   */
  private function isValidWindow(int $start, int $end): bool {
    return $start >= 0 && $start < 1440 && $end >= 0 && $end <= 1440 && $end !== $start;
  }

  /**
   * Splits a window into one or two linear half-open day segments.
   *
   * @return array<array{int, int}>
   *   The non-empty segments within [0, 1440).
   */
  private function segments(int $start, int $end): array {
    if ($end > $start) {
      return [[$start, $end]];
    }

    return [[$start, 1440], [0, $end]];
  }

}
