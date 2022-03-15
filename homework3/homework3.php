<?php
    function calculateGrade($scores = [], $drop=false) : float {
        if(sizeof($scores) < 1) {return 0;}
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
        if($total_points !== 0) {
            return round( ((100 * $total_score) / $total_points), 3);
        }
        else {
            return 0;
        }
    }

    function gridCorners($width=0, $height=0) : string { 

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
        else if($width < 1 || $height < 1) {
            return "";
        }
        else {
            if($height === 1 && $width === 1) {
                return "1";
            }
            else {
                if($width === 1) {
                    $width_edge_case = "";
                    for($i = 1; $i < $height; $i++) {
                        $width_edge_case = $width_edge_case . "$i, ";
                    }
                    $width_edge_case = $width_edge_case . "$height";
                    return $width_edge_case;
                }
                else {
                    $height_edge_case = "";
                    for($i = 1; $i < $width; $i++) {
                        $height_edge_case = $height_edge_case . "$i, ";
                    }
                    $height_edge_case = $height_edge_case . "$width";
                    return $height_edge_case;
                }
            }
        }
    }

    function combineShoppingLists(...$lists) : array {
        $combined_list = [];
        foreach($lists as $list) {
            if(sizeof($list) > 0) {
                foreach($list["list"] as $value) {
                    if(isset($combined_list[$value])) {
                        if(!in_array($list["user"], $combined_list[$value])){
                            $combined_list[$value][] = $list["user"];                   
                        }
                    }
                    else {
                        $combined_list[$value] = [$list["user"]];
                    }
                }
            }
        }
        ksort($combined_list, SORT_NATURAL);
        return $combined_list;
    }

    function validateEmail($email, $regex = "//") : bool {
        $email_regex = "/^[A-Z|a-z|0-9|\_|\+|\-][A-Za-z0-9\_\.\_\+\-]*[A-Za-z0-9\_\_\+\-][@][A-Za-z0-9\.\-]*[.a-zA-Z]*[\.]{1}[A-Za-z]*/";

        $email_bool = preg_match($email_regex, $email);
        $regex_bool = preg_match($regex, $email);
        return (bool) ($email_bool && $regex_bool);
        
    }
