<?php

header('Content-Type: application/json');

try {
    $response = uploadFile();
    if(isset($response['file'])){
        $parseFile = parseFile($response['file']);
        $response['parseFile'] = $parseFile;
        echo json_encode($response);
    }else{
        echo json_encode($response);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
function uploadFile(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['file'])) {
            $target_dir = './files/';
            $target_file = $target_dir . basename($_FILES['file']['name']);
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                $response = ['success' => true, 'message' => 'Файл успешно загружен', 'file' => $target_file];
            } else {
                $response = ['success' => false, 'message' => 'Ошибка загрузки файла'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Нет файла для загрузки'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Ошибка запроса'];
    }

// Throw an error if there was a problem with the file upload
    if (isset($response['success']) && !$response['success']) {
        throw new Exception($response['message']);
    }else{
        return $response;
    }
}

function parseFile($file){
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $result = []; // initialize array to store counts
    foreach ($lines as $i => $line) {
        preg_match_all('/\d/', $line, $matches);
        $count = count($matches[0]);
        $result[] = 'Строка номер ' . ($i + 1) . ' содержит следующее количество цифр ' . $count;
    }
    return $result;
}

