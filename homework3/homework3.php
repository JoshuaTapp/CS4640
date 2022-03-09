<?php
    function calculateAverage($scores, $drop) : float {
        $min_score = PHP_FLOAT_MAX;
        $lowest_score = 0;
        $lowest_points = 0;
        $total_points = 0;
        $total_score = 0;

        foreach($scores as $grade) {
            if($drop === true) {
                $temp = $grade["score"] / $grade["max_points"];
                if ($temp < $min_score) {
                    $min_score = $temp;
                    $lowest_score = $grade["score"];
                    $lowest_points = $grade["max_points"];
                } 
            }
            $total_score += $grade["score"];
            $total_points += $grade["max_points"];
        }
        if($drop === true) {
            $total_points -= $lowest_points;
            $total_score -= $lowest_score;
        }
        return round( ((100 * $total_score) / $total_points), 3);
    }

    function gridCorners($width, $height) : string { 

        if($width > 1 && $height > 1) {
            $bottom_left = 1;
            $top_left = $height;
            $bottom_right = $bottom_left + (($width - 1) * $height);
            $top_right = $width * $height;

            $corners = [
                        // bottom left corner
                        0 => $bottom_left, 1 => $bottom_left + 1, 2 => $bottom_left + $height,
                        // top left corner
                        3 => $top_left, 4 => $top_left - 1, 5 => $top_left + $height,
                        // bottom right corner
                        6 => $bottom_right, 7 => $bottom_right + 1, 8 => $bottom_right - $height,
                        // top right corner
                        9 => $top_right, 10 => $top_right - 1, 11 => $top_right - $height
                    ];
            $corners = array_unique($corners, SORT_NUMERIC);
            sort($corners, SORT_NUMERIC);
            return implode(', ', $corners);
        }
        else if($width < 1 && $height < 1) {
            return "";
        }
        else {
            if($height === 1 && $width === 1) {
                return "1";
            }
            else {
                if($width === 1) {
                    return "1, " . $height;
                }
                else {
                    return "1, " . $width;
                }
            }
        }
    }

    function combineShoppingLists($list1, $list2) : array {
        $combined_list = [];

        foreach($list1["list"] as $value) {
            $combined_list[$value] = [$list1["user"]];    
        }

        foreach($list2["list"] as $value) {
            if(isset($combined_list[$value])) {
                $combined_list[$value][] =  $list2["user"];
            }
            else {
                $combined_list[$value] = [$list2["user"]];
            }
        }
        ksort($combined_list, SORT_NATURAL);
        return $combined_list;
    }

    function validateEmail($email) : bool {

    }
