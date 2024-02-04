<?php
$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

if (!empty($_FILES['image']['tmp_name'])) {
    $image = curl_file_create($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']);
} else {
    $image = null;
}

$data = [
    'id' => $id,
    'title' => $title,
    'content' => $content,
    'image' => $image,
    '_method' => 'PATCH',
];

$api_url = 'http://localhost:8000/api/posts/'.$id;

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST', 
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        'Content-Type: multipart/form-data',
    ],
]);

$response = curl_exec($curl);

curl_close($curl);

echo $api_url;
header('Location: index.php');
?>