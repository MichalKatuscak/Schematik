<?php

namespace Component\Schema\Generator;

final class RandomeGenerator implements GeneratorInterface
{
    private $level;
    private $functions;
    private $zastup;
    private $geo;

    public function __construct($level, array $functions, array $zastup, array $geo)
    {
        $this->level = $level;
        $this->functions = $functions;
        $this->zastup = $zastup;
        $this->geo = $geo;

        $this->shuffleData();
    }

    public function render()
    {
        $level = $this->level;
        $functions = $this->functions;
        $zastup = $this->zastup;
        $geo = $this->geo;

        $size = [$level, $level];

        list($lines_horizontal, $lines_vertical) = $this->generateLinesCoords($size);
        $lines = array_merge($lines_vertical, $lines_horizontal);

        $points = $this->generatePoints($lines_horizontal, $lines_vertical);

        $svg = (new \Component\Schema\Draw\Schema($size, $lines, $points, $geo, $zastup, $functions))->getSVG();

        $vysledky = $this->generateResults();
        $chars = $this->getUsedChars($points);

        return [
            "data" => $svg,
            "result" => \json_encode($vysledky),
            "used_chars" => implode(",",$chars)
        ];
    }

    private function shuffleData() {
        shuffle($this->zastup);
        shuffle($this->functions);
        shuffle($this->geo);
    }

    private function getUsedChars(array $points)
    {
        $chars = [];

        foreach ($points as $key=>$point) {
            if (!in_array($this->zastup[$point[2]], $chars)) {
                $chars[] = $this->zastup[$point[2]];
            }
        }

        return $chars;
    }

    private function generateResults()
    {
        $vysledky = [];

        foreach ($this->zastup as $i=>$znak) {
            foreach ($this->functions as $k=>$f) {
                if ($k == $i) {
                    $vysledky[$znak] = $f;
                }
            }
        }

        return $vysledky;
    }

    private function generatePoints($lines_horizontal, $lines_vertical)
    {
        $points = [];

        foreach ($lines_horizontal as $line_horizontal) {
            foreach ($lines_vertical as $line_vertical) {
                $test = rand(0,count($this->functions)-1);
                $points[] = [
                    $line_horizontal[0][0],
                    $line_vertical[1][1],
                    $test
                ];
            }
        }

        return $points;
    }

    private function generateLinesCoords(array $size) {
        $lines_horizontal = [];
        $lines_vertical = [];

        $starts = [];

        foreach($size as $x_or_y=>$value) {
            $count = 0;
            while($this->level > $count) {
                $one_point = rand(1, $size[$x_or_y]);
                $max_point = $size[(int)!$x_or_y]+1;

                if ($x_or_y) { // X
                    $start = [$one_point, 0];
                    $end = [$one_point, $max_point];
                } else { // Y
                    $start = [0, $one_point];
                    $end = [$max_point, $one_point];
                }

                if (!in_array($start, $starts)) {
                    $starts[] = $start;
                    $ends[] = $end;

                    if ($x_or_y) {
                        $lines_horizontal[] = [$start, $end];
                    } else {
                        $lines_vertical[] = [$start, $end];
                    }
                    $count++;
                }
            }
        }

        return [
            $lines_horizontal,
            $lines_vertical
        ];
    }

}