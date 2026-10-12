<?php

namespace Drupal\pcp_f2_fixture;

/**
 * Detects collisions between same-day half-open time windows.
 *
 * Minute zero is midnight. In this immutable baseline, intervals crossing
 * midnight are intentionally unsupported; see proposed WorkOrder F2-T01.
 */
final class WindowOverlapDetector {

  /**
   * Returns TRUE if two valid same-day windows share at least one minute.
   *
   * Touching endpoints do not overlap: [540, 600) and [600, 660) are separate.
   * All intervals are in integer minutes within one day: 0 through 1440.
   */
  public function intersects(int $start, int $end, int $otherStart, int $otherEnd): bool {
    if (!$this->isSameDayWindow($start, $end) || !$this->isSameDayWindow($otherStart, $otherEnd)) {
      return FALSE;
    }

    return $start < $otherEnd && $otherStart < $end;
  }

  /**
   * Only non-empty, strictly ordered same-day windows are initially valid.
   */
  private function isSameDayWindow(int $start, int $end): bool {
    return $start >= 0 && $start < 1440 && $end > $start && $end <= 1440;
  }

}
