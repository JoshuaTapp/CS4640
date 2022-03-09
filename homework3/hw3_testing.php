<?php
    include("homework3.php");
?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
    
  <title>Homework 3 Test File</title>
</head>
<body>
<h1>Homework 3 Test File</h1>

<h2>Problem 1</h2>
<?php
    echo "Write tests for Problem 1 here\n";
    $test1 = [ [ "score" => 55, "max_points" => 150 ], [ "score" => 55, "max_points" => 130 ], [ "score" => 85, "max_points" => 100 ] ];
    echo "<h1> Calculate Average Tests </h1>";
    echo "<p>" . calculateAverage($test1, false) . "</p>"; // should be 65
    echo "<p>" . calculateAverage($test1, true) . "</p>"; // should be 70


    echo "<h1> Grid Corners Tests </h1>";
    echo "<p>" . gridCorners(3, 4) . "</p>"; // should be [ 1, 2, 3, 4, 5, 8, 9, 10, 11, 12 ]
    echo "<p>" . gridCorners(1, 1) . "</p>"; // should be [ 1 ]
    echo "<p>" . gridCorners(5, 1) . "</p>"; // should be [1, 5]
    echo "<p>" . gridCorners(0, 0) . "</p>"; // should be empty string
    echo "<p>" . gridCorners(1, 7) . "</p>"; // should be [1, 7];


    echo "<h1> Shopping Lists Tests </h1>";
    $list1 = [ "user" => "Fred", 
           "list" => ["frozen pizza", "bread", "apples", "oranges"]
         ];

    $list2 = [ "user" => "Wilma",
           "list" => ["bread", "apples", "coffee"]
         ];
    /* Should be: 
      [
          "apples" => [ "Fred", "Wilma" ],
          "bread" => [ "Fred", "Wilma" ],
          "coffee" => [ "Wilma" ],
          "frozen pizza" => [ "Fred" ],
          "oranges" => [ "Fred" ]
      ]
    */
    $merged_list = combineShoppingLists($list1, $list2);
    echo '<pre>';
    echo var_dump($merged_list);
    echo '</pre>';
  
 

?>

<p>...</p>
</body>
</html>