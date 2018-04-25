<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Get Post data
    $name = strip_tags(trim($_POST['name']));
    $email = filter_var(trim($_POST['name']), FILTER_SANITIZE_EMAIL);
    $recipient = $_POST['recipient'];
    $subject = $_POST['subject'];

    //Validation
    if(empty($name) || empty($email)){
        //Send error
        http_response_code(400);
        echo "Please fill out the fields";
        exit;
    }

    //Build Email
    $message = "Name: $name\n";
    $message .= "Email: $email\n\n";

    //Build Headers
    $headers = 'From: $name <$email>';

    //Send emails
    if(mail($message, $headers, $subject, $recipient)){
        http_response_code(200);
        echo "You're now subscribed";
    } else {
        http_response_code(500);
        echo "There was a problem";
    }
} else {
    http_response_code(403);
    echo "There was a problem";
}