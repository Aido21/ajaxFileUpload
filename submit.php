<?php

if (isset($_POST['images']) && !empty($_FILES)) {
    echo json_encode(loadFile($_FILES));
}
if (empty($_FILES)) {
    echo "pls select file(s)";
}

function loadFile($images)
{
    // $root = $_SERVER['DOCUMENT_ROOT'];
    $files = array();
    foreach ($images as $image) {
        if (move_uploaded_file($image['tmp_name'], "img/{$image['name']}")) {
            $files[] = "img/". $image['name'];
        }
    }
    $data = $files ? array('files' => $files) : array('error' => 'Upload error.');

    return $data;
};
