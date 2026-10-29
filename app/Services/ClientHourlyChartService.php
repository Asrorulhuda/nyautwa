<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ClientHourlyChartService {
    public function getChartData(string $tenantId, string $todayStart): array {
        $rows = Database::fetchAll(
            "SELECT HOUR(created_at) as hr, COUNT(*) as cnt 
             FROM messages 
             WHERE tenant_id = :tid AND created_at >= :t 
             GROUP BY HOUR(created_at)",
            ['tid' => $tenantId, 't' => $todayStart]
        );

        $counts = array_fill(0, 24, 0);
        foreach ($rows as $r) {
            $h = (int) $r['hr'];
            if ($h >= 0 && $h < 24) {
                $counts[$h] = (int) $r['cnt'];
            }
        }

        $max = max(max($counts), 1);
        $hasData = array_sum($counts) > 0;
        $width = 700;
        $baselineY = 160;
        $topY = 25;
        $heightSpan = $baselineY - $topY;

        $points = [];
        $lineCommands = [];

        for ($h = 0; $h < 24; $h++) {
            $x = round(($h / 23) * $width, 1);
            $y = $hasData ? round($baselineY - (($counts[$h] / $max) * $heightSpan), 1) : $baselineY;
            $points[] = ['x' => $x, 'y' => $y, 'count' => $counts[$h], 'hour' => sprintf('%02d:00', $h)];
            $lineCommands[] = ($h === 0 ? "M $x,$y" : "L $x,$y");
        }

        $linePath = implode(' ', $lineCommands);
        $areaPath = $linePath . " L $width,$baselineY L 0,$baselineY Z";

        return [
            'has_data' => $hasData,
            'max_val' => $max,
            'line_path' => $linePath,
            'area_path' => $areaPath,
            'points' => $points,
            'counts' => $counts,
        ];
    }
}
