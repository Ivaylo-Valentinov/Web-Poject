<?php
  require_once "book.php";
  require_once "referat.php";
  require_once "requestUtility.php";

  $errors = [];
  $response = [];
  $referat = new Referat();
  $book = new Book();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['files'])) {

    $csv_file = null;
    $files;
    $pictures;
    $count = count($_FILES['files']['name']);
    for ($i = 0; $i < $count; $i++) {
        if ($_FILES['files']['type'][$i] === 'application/pdf') {
            $files[$_FILES['files']['name'][$i]] = [
                "type" => $_FILES['files']['type'][$i], 
                "tmp_name" => $_FILES['files']['tmp_name'][$i]
            ];
        } elseif ($_FILES['files']['type'][$i] === 'application/vnd.ms-excel' || $_FILES['files']['type'][$i] === 'text/csv') {
            $csv_file = $_FILES['files']['tmp_name'][$i];
        } else {
            $pictures[$_FILES['files']['name'][$i]] = [
                "tmp_name" => $_FILES['files']['tmp_name'][$i]
            ];
        }
    }

    if (is_null($csv_file)) {
        $errors[] = "Must upload csv file with metadata for the books.";
    }

    if (!$errors && (($handle = fopen($csv_file, "r")) !== FALSE)) {
        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            $title = $data[0];
            $author = $data[1];
            $desc = $data[2];
            $count = $data[3];
            $type = $data[4];
            $file_name = $data[5];
            $img_name = $data[6];

            if (!isset($files[$file_name])) {
                continue;
            }

            $file_tmp_name = $files[$file_name]["tmp_name"];
            $file_type = $files[$file_name]["type"];

            $file_name = uniqid().$file_name;
            $link = "pdfs/".$file_name;

            $img_tmp_name = $pictures[$img_name]["tmp_name"];
            $img_name = uniqid().$img_name;

            $image = "img/".$img_name;

            $result;
            if ($type === "Book") {
                $uploadResult = $book->saveBookPDF($file_tmp_name, $file_name, $file_type);
                if (!$uploadResult["success"]) {
                    continue;
                }

                $imageUploadResult = $book->saveImage($img_tmp_name, $img_name);
                if (!$imageUploadResult["success"]) {
                    unlink("../pdfs/".$file_name);
                    continue;
                }

                $result = $book->insertBook($title, $author, $desc, $count, $link, $image);
            } else {
                $uploadResult = $referat->saveReferatPDF($file_tmp_name, $file_name, $file_type);
                if (!$uploadResult["success"]) {
                    continue;
                }

                $imageUploadResult = $referat->saveImage($img_tmp_name, $img_name);
                if (!$imageUploadResult["success"]) {
                    unlink("../pdfs/".$file_name);
                    continue;
                }

                $result = $referat->insertReferat($title, $author, $desc, $count, $link, $image);
            }

            if(!$result["success"]) {
                unlink("../pdfs/".$file_name);
                unlink("../img/".$img_name);
            }
        }
        fclose($handle);
    }
} else  {
    $errors[] = "Not valid method";
}

  RequestUtility::sendResponse($response, $errors);
?>
