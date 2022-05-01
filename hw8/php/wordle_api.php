<?php


    $url = 'http://www.cs.virginia.edu/~jh2jf/courses/cs4640/spring2022/wordlist.txt';

    $file_name = basename($url);
    
    if(file_exists($file_name) == false)
    {
        if (file_put_contents($file_name, file_get_contents($url)))
        {
            //echo "File downloaded successfully\n";
        }
        else
        {
            error_log("File downloading failed.\n");
            die();
        }
    }
    
    $word_bank = file("$file_name", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // echo print_r($word_bank, true);

    $word = $word_bank[array_rand($word_bank)];

    header('Content-type: application/json');
    echo json_encode($word, true) . "\n";
    exit();






