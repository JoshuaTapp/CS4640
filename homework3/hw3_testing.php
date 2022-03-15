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
    echo "<p>" . calculateGrade($test1, false) . "</p>"; // should be 65
    echo "<p>" . calculateGrade($test1, true) . "</p>"; // should be 70


    echo "<h1> Grid Corners Tests </h1>";
    echo "<p>" . gridCorners(3, 4) . "</p>"; // should be [ 1, 2, 3, 4, 5, 8, 9, 10, 11, 12 ]
    echo "<p>" . gridCorners(1, 1) . "</p>"; // should be [ 1 ]
    echo "<p>" . gridCorners(5, 1) . "</p>"; // should be [1, 5]
    echo "<p>" . gridCorners(0, 0) . "</p>"; // should be empty string
    echo "<p>" . gridCorners(1, 7) . "</p>"; // should be [1, 7];


    echo "<h1> Shopping Lists Tests </h1>";
    $list1 = [ "user" => "Fred", 
           "list" => ["frozen pizza", "bread", "apples", "oranges", "bread"]
         ];

    $list2 = [ "user" => "Wilma",
           "list" => ["bread", "apples", "coffee", "bread"]
         ];

    $list3 = [ "user" => "Bob",
            "list" => []
        ];

    $list4 = [];
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

    $merged_list = combineShoppingLists($list1);
    echo '<pre>';
    echo var_dump($merged_list);
    echo '</pre>';

    $merged_list = combineShoppingLists($list3, $list1, $list2);
    echo '<pre>';
    echo var_dump($merged_list);
    echo '</pre>';

    $merged_list = combineShoppingLists($list4);
    echo '<pre>';
    echo var_dump($merged_list);
    echo '</pre>';
  
    echo "<h1> EMAIL TESTS </h1>";
    echo "<p>TRUE - orange@virginia.edu: " . (bool) validateEmail("orange@virginia.edu") . "</p>"; // returns true

    echo "<p>TRUE - no-reply@google.com: " . validateEmail("no-reply@google.com") . "</p>"; // returns true

    echo "<p>TRUE - orange.and.+blue@virginia.edu: " . validateEmail("orange.and.+blue@virginia.edu") . "</p>"; // returns true

    echo "<p>FALSE - .orange.and.+blue@virginia.edu: " . validateEmail(".orange.and.+blue@virginia.edu") . "</p>"; 

    echo "<p>TRUE - lkjs-df_123a.sd@amazon.co.uk.yum: " . validateEmail("lkjs-df_123a.sd@amazon.co.uk.yum") . "</p>"; 

    echo "<p>FALSE - google.com: " . validateEmail("google.com") . "</p>"; // returns false

    echo "<p>TRUE - mst3k@virginia.edu (with regex): " . validateEmail("mst3k@virginia.edu", "/^[a-z][a-z][a-z]?[0-9][a-z][a-z]?[a-z]?@virginia.edu$/") . "</p>"; // returns true

    echo "<p>FALSE - orangeblue.com (with regex): " . validateEmail("orangeblue.com", "/^[a-z\.@]+$/") . "</p>"; // returns false

    echo "<p>FALSE - orange123@blue.com (with regex): " . validateEmail("orange123@blue.com", "/^[a-z\.@]+$/") . "</p>";

    echo "<p>FALSE - orange@virginia.edu (with regex): " . validateEmail("orange@virginia.edu", "/^[a-z][a-z][a-z]?[0-9][a-z][a-z]?[a-z]?@virginia.edu$/") . "</p>";

    echo "<p>TRUE - orange@blue.com (with regex): " . validateEmail("orange@blue.com", "/^[a-z\.@]+$/") . "</p>";

    echo "<p>TRUE - jh2jf@gmail.com, /^[a-zA-Z0-9.@]+$/: " . validateEmail("jh2jf@gmail.com", "/^[a-zA-Z0-9.@]+$/") . "</p>";

    echo "<p>FALSE - jh44hgmail.c@om, /^[a-zA-Z0-9.@]+$/: " . validateEmail("jh44hgmail.c@om", "/^[a-zA-Z0-9.@]+$/") . "</p>";

    echo "<p>FALSE - john_smith@mit.edu, /^[a-zA-Z0-9.@]+$/: " . validateEmail("john_smith@mit.edu", "/^[a-zA-Z0-9.@]+$/") . "</p>";



    

    

?>

<p>...</p>
</body>
</html>